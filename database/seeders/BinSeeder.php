<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bin;

class BinSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        Bin::truncate();

        $locations = [
            ['name' => 'Main Street Park', 'lat' => 1.1043, 'lng' => 104.0304],
            ['name' => 'Central Market', 'lat' => 1.1055, 'lng' => 104.0287],
            ['name' => 'City Plaza', 'lat' => 1.1078, 'lng' => 104.0310],
            ['name' => 'Beach Park', 'lat' => 1.1089, 'lng' => 104.0265],
            ['name' => 'Shopping Mall', 'lat' => 1.1112, 'lng' => 104.0324],
            ['name' => 'Bus Terminal', 'lat' => 1.1134, 'lng' => 104.0298],
            ['name' => 'Sports Complex', 'lat' => 1.1156, 'lng' => 104.0276],
            ['name' => 'Hospital Area', 'lat' => 1.1021, 'lng' => 104.0289],
            ['name' => 'University Campus', 'lat' => 1.1067, 'lng' => 104.0331],
            ['name' => 'Industrial Park', 'lat' => 1.1145, 'lng' => 104.0312],
        ];

        $statuses = ['Full', 'Normal', 'Normal', 'Normal', 'Maintenance'];

        foreach ($locations as $index => $location) {
            $binNumber = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            
            // 🔥 BIN 001 = SENSOR REAL, sisanya random
            if ($binNumber === '001') {
                // BIN 001 - Connected to IoT Sensor (ESP32)
                $status = 'Normal'; // Default awal Normal
                $capacity = 45; // Capacity awal
                $battery = 85; // Battery bagus
                $this->command->info('🔌 BIN 001 - IoT Sensor Connected (ESP32)');
            } else {
                // BIN 002-010 - Random Dummy Data
                $status = $statuses[array_rand($statuses)];
                
                $capacity = match($status) {
                    'Full' => rand(85, 100),
                    'Normal' => rand(30, 75),
                    'Maintenance' => rand(0, 50),
                };
                
                $battery = rand(40, 100);
            }

            Bin::create([
                'bin_id' => $binNumber,
                'name' => "Bin #{$binNumber}",
                'location' => $location['name'],
                'latitude' => $location['lat'],
                'longitude' => $location['lng'],
                'status' => $status,
                'capacity' => $capacity,
                'battery' => $battery,
                'last_updated' => now()->subMinutes(rand(1, 60)),
                'is_active' => $status !== 'Maintenance', // Maintenance = inactive
                'homebase_id' => null // Bisa diisi nanti kalau ada homebase
            ]);
        }

        $this->command->info('✅ 10 bins created successfully!');
        $this->command->info('📍 BIN 001: IoT Sensor (Real-time)');
        $this->command->info('📍 BIN 002-010: Manual/Dummy Data');
    }
}