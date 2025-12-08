<?php
 
namespace App\Console;
 
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PurgeDatabaseCache;
 
class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sitemap:generate')->daily();
        // Auto-prune DB cache weekly
        $schedule->command('cache:prune-db')->weekly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
