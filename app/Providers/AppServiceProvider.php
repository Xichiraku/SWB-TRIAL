<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Bin;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 🔥 Composer untuk semua halaman operator
        View::composer('operator.*', function ($view) {
            // Hitung notifikasi baru dari bins (Full + Maintenance)
            $fullBinsCount = Bin::where(function($query) {
                $query->where('status', 'Full')
                      ->orWhere('capacity', '>=', 85);
            })->where('status', '!=', 'Maintenance')
              ->count();
            
            $maintenanceBinsCount = Bin::where('status', 'Maintenance')->count();
            
            // Total notifikasi
            $totalNotifications = $fullBinsCount + $maintenanceBinsCount;
            
            // Kirim data ke view
            $view->with([
                'pendingTasks' => $totalNotifications,      // Badge di bell icon
                'unreadNotifications' => $totalNotifications // Backup variable
            ]);
        });
    }
}