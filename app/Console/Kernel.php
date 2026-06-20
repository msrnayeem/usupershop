<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Check subscription expiry every day at 8:00 AM Bangladesh time (UTC+6 = 02:00 UTC)
        $schedule->command('subscription:check-expiry')->dailyAt('02:00');
        // Clean abandoned orders (unpaid for 24h+) every 6 hours
        $schedule->command('orders:clean-abandoned')->everySixHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
