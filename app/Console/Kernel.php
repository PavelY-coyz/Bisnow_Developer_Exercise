<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\TrackWebsiteViewSummary',
        'App\Console\Commands\TrackWebsiteViewEvents',
        'App\Console\Commands\TrackWebsiteViewNews',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //setup a cron to run this.

        //At the start of each day update the tracking summary table with data
        //from the previous day.
        $schedule->command('track:events')->dailyAt('00:00');
        $schedule->command('track:news')->dailyAt('00:00');
        $schedule->command('track:summary')->dailyAt('00:00');

        //For testing todays activity. Variables inside each command class need to be altered too
        //After altering each command file run php artisan schedule:run to test
        //$schedule->command('track:events')->everyMinute();
        //$schedule->command('track:news')->everyMinute();
        //$schedule->command('track:summary')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
