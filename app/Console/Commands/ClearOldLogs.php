<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearOldLogs extends Command
{
    protected $signature = 'logs:clear-old';
    protected $description = 'Delete Laravel log files older than 1 day';

    public function handle()
    {
        $logPath = base_path('vms-system/storage/logs');  // your log folder
        $days = 1;  // delete logs older than 1 day

        foreach (glob($logPath . '/*.log') as $file) {

            if (filemtime($file) < now()->subDays($days)->timestamp) {
                unlink($file);
            }
        }

        $this->info("Old log files deleted successfully.");
    }
}
