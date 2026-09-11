<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GasAlertService
{
    public const DEVICE_CO2 = 30000;
    public const DEVICE_PH3 = 30001;
    private const DEVICE_TYPE_IDS = [self::DEVICE_CO2, self::DEVICE_PH3];
    private const ALERT_TYPES = ['severe', 'critical', 'normal', 'unknown'];

    // All endpoints use the same base URL from config
    private function baseUrl(): string
    {
        return config('external-apis.master_alerts');
    }

    /* ── Fetch alert records ── */
    public function fetchAlerts(array $params = []): array
    {
        try {
            $deviceTypeId = isset($params['deviceTypeId'])
                && in_array((int) $params['deviceTypeId'], self::DEVICE_TYPE_IDS, true)
                    ? (int) $params['deviceTypeId']
                    : null;

            $alertType = isset($params['alertType'])
                ? strtolower(trim((string) $params['alertType']))
                : null;

            if (!in_array($alertType, self::ALERT_TYPES, true)) {
                $alertType = null;
            }

            $page     = max(1, (int) ($params['pageNumber'] ?? 1));
            $pageSize = min(10000, max(1, (int) ($params['pageSize'] ?? 20)));
            $query    = [
                'deviceTypeId' => $deviceTypeId,
                'state'        => $params['state']        ?? null,
                'location'     => $params['location']     ?? null,
                'alertType'    => $alertType,
                'device'       => $params['device']       ?? null,
                'fromDate'     => $params['fromDate']     ?? null,
                'toDate'       => $params['toDate']       ?? null,
                'showNormal'   => $params['showNormal']   ?? null,
            ];

            if ($deviceTypeId === null) {
                return $this->requestAlerts($query + [
                    'pageNumber' => $page,
                    'pageSize'   => $pageSize,
                ]);
            }

            /*
             * The upstream endpoint currently ignores deviceTypeId for unfiltered,
             * NORMAL and UNKNOWN requests. Scan its chronological result set and
             * paginate only after applying the device id locally. This prevents a
             * CO2 page from containing PH3 rows (and vice versa).
             */
            $requiredRows = $page * $pageSize;
            $scanPageSize = min(2000, max(200, $requiredRows * 5));
            $maxScanPages = 10;
            $matches      = [];
            $upstreamTotal = 0;
            $scannedRows   = 0;
            $hasMore       = false;

            for ($scanPage = 1; $scanPage <= $maxScanPages; $scanPage++) {
                $payload = $this->requestAlerts($query + [
                    'pageNumber' => $scanPage,
                    'pageSize'   => $scanPageSize,
                ]);

                $rows = is_array($payload['data'] ?? null) ? $payload['data'] : [];
                if ($scanPage === 1) {
                    $upstreamTotal = (int) ($payload['totalCount'] ?? count($rows));
                }

                $scannedRows += count($rows);
                foreach ($rows as $row) {
                    if (!is_array($row) || !$this->matchesDeviceType($row, $deviceTypeId)) {
                        continue;
                    }

                    if ($alertType !== null
                        && strtolower(trim((string) ($row['alertType'] ?? ''))) !== $alertType) {
                        continue;
                    }

                    $matches[] = $row;
                }

                $hasMore = $scannedRows < $upstreamTotal;
                if (count($matches) >= $requiredRows || !$hasMore || $rows === []) {
                    break;
                }
            }

            $offset = ($page - 1) * $pageSize;
            $data   = array_slice($matches, $offset, $pageSize);

            // SEVERE/CRITICAL totals are correctly filtered by the upstream API.
            $hasReliableTotal = in_array($alertType, ['severe', 'critical'], true);

            return [
                'data'               => $data,
                'totalCount'         => $hasReliableTotal ? $upstreamTotal : count($matches),
                'upstreamTotalCount' => $upstreamTotal,
                'hasMore'            => $hasMore || count($matches) > ($offset + count($data)),
                'filteredLocally'     => true,
            ];

        } catch (\Exception $e) {
            Log::error('Master Alerts API Error', ['message' => $e->getMessage()]);
            return ['data' => [], 'totalCount' => 0];
        }
    }

    /**
     * Walk EVERY matching record for the given filters — no pageSize cap —
     * invoking $callback for each row as it streams in from upstream, so
     * exports never truncate at an artificial limit and never hold the
     * full result set in memory at once.
     */
    public function eachAlert(array $params, callable $callback): void
    {
        $deviceTypeId = isset($params['deviceTypeId'])
            && in_array((int) $params['deviceTypeId'], self::DEVICE_TYPE_IDS, true)
                ? (int) $params['deviceTypeId']
                : null;

        $alertType = isset($params['alertType'])
            ? strtolower(trim((string) $params['alertType']))
            : null;

        if (!in_array($alertType, self::ALERT_TYPES, true)) {
            $alertType = null;
        }

        $query = [
            'deviceTypeId' => $deviceTypeId,
            'state'        => $params['state']      ?? null,
            'location'     => $params['location']   ?? null,
            'alertType'    => $alertType,
            'device'       => $params['device']     ?? null,
            'fromDate'     => $params['fromDate']   ?? null,
            'toDate'       => $params['toDate']     ?? null,
            'showNormal'   => $params['showNormal'] ?? null,
        ];

        // The upstream API silently clamps pageSize to 500 regardless of what
        // is requested — so "rows returned < pageSize" is NOT a safe way to
        // detect the last page (every page returns exactly 500 until the
        // real end). Track fetched-count against the reported totalCount
        // from the first page instead.
        $pageSize      = 500;
        $page          = 1;
        $seenIds       = [];
        $fetchedRaw    = 0;
        $upstreamTotal = null;
        $maxPagesLimit = 20000; // safety net only (~10M raw rows) — not a real-world cap

        while ($page <= $maxPagesLimit) {
            $payload = $this->requestAlerts($query + [
                'pageNumber' => $page,
                'pageSize'   => $pageSize,
            ]);

            $rows = is_array($payload['data'] ?? null) ? $payload['data'] : [];
            if ($rows === []) {
                break;
            }

            if ($upstreamTotal === null) {
                $upstreamTotal = (int) ($payload['totalCount'] ?? 0);
            }

            foreach ($rows as $row) {
                if (!is_array($row)) {
                    continue;
                }

                if ($deviceTypeId !== null && !$this->matchesDeviceType($row, $deviceTypeId)) {
                    continue;
                }

                // Some upstream pages overlap near the boundary — skip dupes.
                $id = $row['id'] ?? null;
                if ($id !== null) {
                    if (isset($seenIds[$id])) {
                        continue;
                    }
                    $seenIds[$id] = true;
                }

                $callback($row);
            }

            $fetchedRaw += count($rows);

            if (count($rows) < $pageSize) {
                break; // upstream genuinely ran out of rows
            }

            if ($upstreamTotal > 0 && $fetchedRaw >= $upstreamTotal) {
                break; // reached (or passed) the reported total
            }

            $page++;
        }
    }

    /**
     * Accurate total count for a specific alertType, straight from the
     * upstream API's own totalCount field (no local scanning/early-break).
     *
     * Verified against the live API: for a given deviceTypeId+state+location,
     * totalCount(normal) + totalCount(severe) + totalCount(critical) ==
     * totalCount(no alertType filter) exactly — so these three numbers are
     * safe to use directly for KPI counts. Do NOT pass alertType=unknown
     * here: upstream ignores that filter and returns the unfiltered total.
     */
    public function reliableTotalCount(array $filters, ?string $alertType = null): int
    {
        $payload = $this->requestAlerts($filters + [
            'pageNumber' => 1,
            'pageSize'   => 1,
            'alertType'  => $alertType,
        ]);

        return (int) ($payload['totalCount'] ?? 0);
    }

    private function requestAlerts(array $query): array
    {
        $response = Http::timeout(config('external-apis.timeout_default', 20))
            ->retry(2, 100)
            ->get($this->baseUrl(), array_filter($query, fn($value) => $value !== null && $value !== ''));

        if ($response->failed()) {
            Log::error('Master Alerts API Failed', [
                'status' => $response->status(),
                'query'  => $query,
            ]);

            return ['data' => [], 'totalCount' => 0];
        }

        $payload = $response->json();

        return is_array($payload)
            ? $payload
            : ['data' => [], 'totalCount' => 0];
    }

    public function matchesDeviceType(array $alert, int $deviceTypeId): bool
    {
        if (isset($alert['deviceTypeId'])) {
            return (int) $alert['deviceTypeId'] === $deviceTypeId;
        }

        $deviceType = strtoupper(trim((string) ($alert['deviceType'] ?? '')));

        return ($deviceTypeId === self::DEVICE_CO2 && in_array($deviceType, ['CO2', 'CO₂'], true))
            || ($deviceTypeId === self::DEVICE_PH3 && in_array($deviceType, ['PH3', 'PH₃'], true));
    }
    /* ── Fetch by warehouse nms_id ── */
    public function fetchByWarehouse(int $nmsId, array $params = []): array
    {
        try {
            $url = $this->baseUrl() . '/devices/' . $nmsId;
            $query = array_filter([
                'pageNumber' => $params['pageNumber'] ?? 1,
                'pageSize'   => $params['pageSize']   ?? 20,
            ], fn($v) => !is_null($v));

            $r = Http::timeout(20)->retry(2, 200)->get($url, $query);
            if ($r->failed()) return ['data' => [], 'totalCount' => 0];
            $json = $r->json();

            $typeLabel = isset($params['deviceTypeId'])
                && (int) $params['deviceTypeId'] === self::DEVICE_PH3
                    ? 'PH3'
                    : 'CO2';

            $data = collect($json['data'] ?? [])->map(fn($d) => [
                'nms_id'        => $nmsId,
                'base_id'       => $json['warehouseId'] ?? null,
                'deviceName'    => $d['name']           ?? '',
                'deviceType'    => $d['type']           ?? '',
                'shadName'      => explode(' / ', $d['location'] ?? '/')[0] ?? '',
                'columnName'    => explode(' / ', $d['location'] ?? '/')[1] ?? '',
                'locationName'  => $d['warehouse']      ?? '',
                'location'      => $d['warehouse']      ?? '',
                'warehouseCode' => $d['warehouseCode']  ?? '',
                'state'         => $d['region']         ?? '',
                'regionCode'    => $d['regionCode']     ?? '',
                'deviceIp'      => $d['deviceIp']       ?? '',
                'deviceValue'   => $d['latestReading']  ?? 'N/A',
                'unit'          => $d['unit']           ?? 'ppm',
                'alertType'     => match(strtolower($d['level'] ?? '')) {
                    'severe'   => 'SEVERE',
                    'critical' => 'CRITICAL',
                    default    => 'NORMAL',
                },
                'deviceStatus'  => ucfirst($d['status'] ?? ''),
                'regDate'       => $d['latestReadingTime'] ?? null,
            ]);

            // Filter by deviceType and alertType client-side
            if (!empty($params['deviceTypeId'])) {
                $data = $data->filter(fn($d) => strtoupper($d['deviceType']) === $typeLabel);
            }
            if (!empty($params['alertType'])) {
                $data = $data->filter(fn($d) => $d['alertType'] === strtoupper($params['alertType']));
            }

            $data     = $data->values();
            $total    = $data->count();
            $page     = (int)($params['pageNumber'] ?? 1);
            $pageSize = (int)($params['pageSize']   ?? 20);

            return [
                'data'       => $data->slice(($page - 1) * $pageSize, $pageSize)->values()->toArray(),
                'totalCount' => $total,
            ];
        } catch (\Exception $e) {
            Log::error('GasAlert fetchByWarehouse error', ['nmsId' => $nmsId, 'msg' => $e->getMessage()]);
            return ['data' => [], 'totalCount' => 0];
        }
    }

    /* ── States — from API /states endpoint ── */
    public function states(): array
    {
        return Cache::remember('gas_alert_states', config('external-apis.cache_states', 300), function () {
            try {
                $r = Http::timeout(10)->retry(2, 100)->get($this->baseUrl() . '/states');
                if ($r->failed()) return [];
                return $r->json() ?? [];
            } catch (\Exception $e) {
                Log::error('GasAlert states error', ['msg' => $e->getMessage()]);
                return [];
            }
        });
    }

    /* ── Locations for a state ── */
    public function locations(string $state): array
    {
        return Cache::remember('gas_alert_locations_' . md5($state), config('external-apis.cache_locations', 300), function () use ($state) {
            try {
                $r = Http::timeout(10)->retry(2, 100)
                    ->get($this->baseUrl() . '/states/' . urlencode($state) . '/locations');
                if ($r->failed()) return [];
                return $r->json() ?? [];
            } catch (\Exception $e) {
                Log::error('GasAlert locations error', ['msg' => $e->getMessage()]);
                return [];
            }
        });
    }

    /* ── KPI summary counts ── */
    public function summary(int $deviceTypeId): array
    {
        return Cache::remember('gas_summary_' . $deviceTypeId, 300, function () use ($deviceTypeId) {
            $n = $this->fetchAlerts(['deviceTypeId' => $deviceTypeId, 'alertType' => 'NORMAL',   'pageSize' => 1]);
            $s = $this->fetchAlerts(['deviceTypeId' => $deviceTypeId, 'alertType' => 'SEVERE',   'pageSize' => 1]);
            $c = $this->fetchAlerts(['deviceTypeId' => $deviceTypeId, 'alertType' => 'CRITICAL', 'pageSize' => 1]);
            return [
                'normal'   => $n['totalCount'] ?? 0,
                'severe'   => $s['totalCount'] ?? 0,
                'critical' => $c['totalCount'] ?? 0,
            ];
        });
    }
}
