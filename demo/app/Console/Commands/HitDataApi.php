<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
 
class HitDataApi extends Command
{
    protected $signature = 'api:hit-data';
    protected $description = 'Hit external data API every 10 seconds';
 
    public function handle()
    {
        // Run 6 times in 1 minute (every 10 sec)
        for ($i = 1; $i <= 6; $i++) {
 
            try {
                $response = Http::timeout(10)->get('http://164.52.202.25:8003/data');
 
                \Log::info('API HIT SUCCESS', [
                    'status' => $response->status(),
                    'time' => now()
                ]);
 
            } catch (\Exception $e) {
                \Log::error('API HIT FAILED: '.$e->getMessage());
            }
 
            sleep(10); // wait 10 sec
        }
 
        return 0;
    }
}