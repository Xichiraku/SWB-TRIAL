<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        Setting::truncate();

        // Create default settings
        Setting::create([
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

        $this->command->info('✅ Default settings created successfully!');
    }
}