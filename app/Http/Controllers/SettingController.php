<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        // Get settings (ID 1 sebagai default)
        $settings = DB::table('settings')->where('id', 1)->first();
        
        // If no settings exist, create default
        if (!$settings) {
            DB::table('settings')->insert([
                'id' => 1,
                'notif_enabled' => false,
                'capacity_alert' => true,
                'battery_alert' => true,
                'nurse_alert' => true,
                'email_notif' => true,
                'push_notif' => true,
                'collection_threshold' => 85,
                'battery_threshold' => 25,
                'refresh_interval' => 30,
                'theme' => 'System',
                'language' => 'English',
                'units' => 'Metric',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $settings = DB::table('settings')->where('id', 1)->first();
        }
        
        return view('admin.settings', compact('settings'));
    }
    
    public function update(Request $request)
    {
        $data = [
            'notif_enabled' => $request->input('notif_enabled', false),
            'capacity_alert' => $request->input('capacity_alert', false),
            'battery_alert' => $request->input('battery_alert', false),
            'nurse_alert' => $request->input('nurse_alert', false),
            'email_notif' => $request->input('email_notif', false),
            'push_notif' => $request->input('push_notif', false),
            'collection_threshold' => $request->input('collection_threshold', 85),
            'battery_threshold' => $request->input('battery_threshold', 25),
            'refresh_interval' => $request->input('refresh_interval', 30),
            'theme' => $request->input('theme', 'System'),
            'language' => $request->input('language', 'English'),
            'units' => $request->input('units', 'Metric'),
            'updated_at' => now()
        ];
        
        DB::table('settings')->where('id', 1)->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully'
        ]);
    }
}
