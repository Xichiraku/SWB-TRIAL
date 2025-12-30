<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Cek session
        if (!session('user')) {
            return redirect('/');
        }

        // Get settings dari database (ambil yang pertama, atau buat default kalau belum ada)
        $settings = Setting::first();

        // Kalau belum ada settings, buat default
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

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'notif_enabled' => 'boolean',
            'capacity_alert' => 'boolean',
            'battery_alert' => 'boolean',
            'nurse_alert' => 'boolean',
            'email_notif' => 'boolean',
            'push_notif' => 'boolean',
            'collection_threshold' => 'integer|min:0|max:100',
            'battery_threshold' => 'integer|min:0|max:100',
            'refresh_interval' => 'integer|min:10|max:120',
            'theme' => 'string',
            'language' => 'string',
            'units' => 'string'
        ]);

        // Get settings pertama atau buat baru
        $settings = Setting::first();

        if ($settings) {
            $settings->update($validated);
        } else {
            $settings = Setting::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'data' => $settings
        ]);
    }
}