<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule): void
    // {
    //     // $schedule->command('inspire')->hourly();
    //     $schedule->command('logs:clear-old')->daily();

    // }

    /**
     * Register the commands for the application.
     */
    
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('logs:clear-old')->daily();
         // run every minute (internally every 10 sec)
        $schedule->command('api:hit-data')->everyMinute()->withoutOverlapping();
 
    }

    



}


