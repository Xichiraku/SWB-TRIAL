<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->updateOrInsert(
            ['id' => 1],
            [
                'notif_enabled' => true,
                'capacity_alert' => true,
                'battery_alert' => true,
                'nurse_alert' => true,
                'email_notif' => true,
                'push_notif' => false,
                'collection_threshold' => 85,
                'battery_threshold' => 20,
                'refresh_interval' => 30,
                'theme' => 'Dark',
                'language' => 'English',
                'units' => 'Metric',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('✅ Settings seeded.');
    }
}