<?php
// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/MasterAlertSummaryService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MasterAlertSummaryService
{
    public function fetchSummary()
    {
        $ttl = config('external-apis.cache_co2_summary', 120);

        return Cache::remember('master_alert_summary', $ttl, function () {
            try {
                $url     = config('external-apis.co2_summary');
                $timeout = config('external-apis.timeout_slow', 30);

                $response = Http::timeout($timeout)
                    ->retry(2, 2000)
                    ->get($url);

                if ($response->failed()) {
                    Log::error('Master Alert Summary Failed', ['url' => $url]);
                    return [];
                }

                return $response->json() ?? [];

            } catch (\Exception $e) {
                Log::error('Master Alert Summary Error', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }
}
