<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SettingController extends Controller
{
    public function index()
    {
        // Session check ditangani middleware role:admin di routes
        // tidak perlu dicek ulang di sini

        $settings = Setting::first() ?? Setting::create([
            'notif_enabled'        => true,
            'capacity_alert'       => true,
            'battery_alert'        => true,
            'nurse_alert'          => true,
            'email_notif'          => true,
            'push_notif'           => false,
            'collection_threshold' => 85,
            'battery_threshold'    => 20,
            'refresh_interval'     => 30,
            'theme'                => 'System',
            'language'             => 'en',
            'units'                => 'Metric',
        ]);

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'notif_enabled'        => 'boolean',
            'capacity_alert'       => 'boolean',
            'battery_alert'        => 'boolean',
            'nurse_alert'          => 'boolean',
            'email_notif'          => 'boolean',
            'push_notif'           => 'boolean',
            'collection_threshold' => 'integer|min:0|max:100',
            'battery_threshold'    => 'integer|min:0|max:100',
            'refresh_interval'     => 'integer|min:10|max:120',
            'theme'                => 'string|max:50',
            'language'             => 'string|max:50',
            'units'                => 'string|max:50',
        ]);

        $settings = Setting::first();

        if ($settings) {
            $settings->update($validated);
        } else {
            $settings = Setting::create($validated);
        }

        $locale = match (strtolower((string) ($settings->language ?? 'en'))) {
            'id', 'bahasa indonesia', 'indonesian', 'indonesia' => 'id',
            'en', 'english' => 'en',
            'zh', '中文', 'chinese' => 'zh',
            default => 'en',
        };

        App::setLocale($locale);
        app('request')->setLocale($locale);
        session()->put('locale', $locale);

        return response()->json([
            'success' => true,
            'message' => __('app.settings_saved'),
            'locale'  => $locale,
            'data'    => $settings,
        ]);
    }
}