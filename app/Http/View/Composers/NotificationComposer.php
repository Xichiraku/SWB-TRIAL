<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Bin;

class NotificationComposer
{
    /**
     * Bind data ke view setiap kali layout operator di-load
     */
    public function compose(View $view)
    {
        // Hitung jumlah bins yang Full
        $fullBinsCount = Bin::where(function($query) {
            $query->where('status', 'Full')
                  ->orWhere('capacity', '>=', 85);
        })->where('status', '!=', 'Maintenance')
          ->count();
        
        // Hitung jumlah bins yang Maintenance
        $maintenanceBinsCount = Bin::where('status', 'Maintenance')->count();
        
        // Total notifikasi baru
        $totalNotifications = $fullBinsCount + $maintenanceBinsCount;
        
        // Kirim ke view
        $view->with('unreadNotifications', $totalNotifications);
    }
}