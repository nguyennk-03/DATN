<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Định nghĩa lịch trình chạy lệnh (Scheduler).
     */
    protected function schedule(Schedule $schedule): void
    {
        // Ví dụ: chạy lệnh 'inspire' mỗi giờ
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Đăng ký các lệnh Artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
