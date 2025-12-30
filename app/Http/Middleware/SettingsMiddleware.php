<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\App;

class SettingsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get settings dari database
        $settings = Setting::first();

        // Kalau belum ada, buat default
        if (!$settings) {
            $settings = Setting::create([
                'notif_enabled' => true,
                'capacity_alert' => true,
                'battery_alert' => true,
                'nurse_alert' => true,
                'email_notif' => true,
                'push_notif' => false,
                'collection_threshold' => 85,
                'battery_threshold' => 20,
                'refresh_interval' => 30,
                'theme' => 'System',
                'language' => 'English',
                'units' => 'Metric'
            ]);
        }

        // Set language berdasarkan settings
        $locale = match($settings->language) {
            'Bahasa Indonesia' => 'id',
            'English' => 'en',
            '中文' => 'zh',
            default => 'en'
        };
        
        App::setLocale($locale);

        // Share settings ke semua views
        view()->share('appSettings', $settings);

        return $next($request);
    }
}