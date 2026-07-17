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
        $settings = Setting::first();

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
                'language' => 'en',
                'units' => 'Metric'
            ]);
        }

        $locale = $this->resolveLocale($settings->language);
        App::setLocale($locale);
        $request->setLocale($locale);
        session()->put('locale', $locale);

        view()->share('appSettings', $settings);

        return $next($request);
    }

    protected function resolveLocale($language): string
    {
        return match (strtolower((string) $language)) {
            'id', 'bahasa indonesia', 'indonesian', 'indonesia' => 'id',
            'en', 'english' => 'en',
            'zh', '中文', 'chinese' => 'zh',
            default => config('app.fallback_locale', 'en'),
        };
    }
}