<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Hitung denda otomatis setiap hari jam 00:01
        $schedule->command('denda:hitung')->dailyAt('00:01');

        // Kirim notifikasi H-1 deadline pengembalian
        $schedule->command('notif:h1-deadline')->dailyAt('08:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
