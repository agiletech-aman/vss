<?php
// ═══════════════════════════════════════════════════════════════
// FILE: app/Services/SackCountingService.php
// ═══════════════════════════════════════════════════════════════

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SackCountingService
{
    public function fetch(array $filters = [])
    {
        $url     = config('external-apis.sack_data');
        $timeout = config('external-apis.timeout_fast', 10);

        return Http::timeout($timeout)
            ->get($url, array_filter($filters))
            ->json();
    }
}
