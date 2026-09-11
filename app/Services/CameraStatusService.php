<?php
// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/CameraStatusService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CameraStatusService
{
    /**
     * Get camera summary statistics
     * Returns: total, online, offline (unknown treated as offline)
     */
    public function getSummary()
    {
        try {
            $url     = config('external-apis.camera_summary');
            $timeout = config('external-apis.timeout_fast', 10);

            $response = Http::timeout($timeout)->get($url);

            if (!$response->successful()) {
                Log::error('Camera Summary API failed', ['status' => $response->status()]);
                return $this->getDefaultSummary();
            }

            $data = $response->json();

            // Check if API returned success
            if (!isset($data['success']) || !$data['success']) {
                Log::error('Camera Summary API returned error', ['data' => $data]);
                return $this->getDefaultSummary();
            }

            $apiData = $data['data'] ?? [];

            $total   = (int) ($apiData['total_cameras'] ?? 0);
            $online  = (int) ($apiData['online_cameras'] ?? 0);
            $offline = (int) ($apiData['offline_cameras'] ?? 0);
            $unknown = (int) ($apiData['unknown_cameras'] ?? 0);

            // Treat unknown as offline
            $offlineTotal = $offline + $unknown;

            return [
                'total'   => $total,
                'online'  => $online,
                'offline' => $offlineTotal,
                'unknown' => $unknown, // Keep for reference if needed
            ];

        } catch (\Exception $e) {
            Log::error('Camera Summary API error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);
            return $this->getDefaultSummary();
        }
    }

    /**
     * Get offline camera count (including unknown)
     * Legacy method for backward compatibility
     */
    public function offlineCount()
    {
        $summary = $this->getSummary();
        return $summary['offline'];
    }

    /**
     * Get total camera count
     */
    public function totalCount()
    {
        $summary = $this->getSummary();
        return $summary['total'];
    }

    /**
     * Get online camera count
     */
    public function onlineCount()
    {
        $summary = $this->getSummary();
        return $summary['online'];
    }

    /**
     * Get online percentage
     */
    public function onlinePercent()
    {
        $summary = $this->getSummary();

        if ($summary['total'] == 0) {
            return 0;
        }

        return round(($summary['online'] / $summary['total']) * 100, 2);
    }

    /**
     * Default summary when API fails
     */
    private function getDefaultSummary()
    {
        return [
            'total'   => 0,
            'online'  => 0,
            'offline' => 0,
            'unknown' => 0,
        ];
    }
}
