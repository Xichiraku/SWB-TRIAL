<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BinSeeder extends Seeder
{
    public function run(): void
    {
        $homebaseId = DB::table('homebases')->where('name', 'Taman Ormawa')->value('id');

        $bins = [
            [
                'bin_id' => 'BIN-BASAH-01',
                'name' => 'Bin Basah 01',
                'type' => 'wet',
                'location' => 'Taman Ormawa',
                'latitude' => 1.1043,
                'longitude' => 104.0304,
                'capacity' => 87,
                'tank_height_cm' => 120,
                'distance_cm' => 15,
                'moisture' => 67,
                'moisture_percent' => 70,
                'moisture_status' => 'wet',
                'last_sort_result' => 'organic',
                'sensor_error' => false,
                'battery' => 35,
                'is_active' => true,
                'homebase_id' => $homebaseId,
                'task_status' => 'pending',
            ],
            [
                'bin_id' => 'BIN-KERING-01',
                'name' => 'Bin Kering 01',
                'type' => 'dry',
                'location' => 'Halaman Gedung Utama',
                'latitude' => 1.1055,
                'longitude' => 104.0287,
                'capacity' => 72,
                'tank_height_cm' => 110,
                'distance_cm' => 30,
                'moisture' => 25,
                'moisture_percent' => 22,
                'moisture_status' => 'dry',
                'last_sort_result' => 'recyclable',
                'sensor_error' => false,
                'battery' => 82,
                'is_active' => true,
                'homebase_id' => DB::table('homebases')->where('name', 'Halaman Gedung Utama')->value('id'),
                'task_status' => null,
            ],
        ];

        foreach ($bins as $bin) {
            DB::table('bins')->updateOrInsert(
                ['bin_id' => $bin['bin_id']],
                [
                    'name' => $bin['name'],
                    'type' => $bin['type'],
                    'location' => $bin['location'],
                    'latitude' => $bin['latitude'],
                    'longitude' => $bin['longitude'],
                    'capacity' => $bin['capacity'],
                    'tank_height_cm' => $bin['tank_height_cm'],
                    'distance_cm' => $bin['distance_cm'],
                    'moisture' => $bin['moisture'],
                    'moisture_percent' => $bin['moisture_percent'],
                    'moisture_status' => $bin['moisture_status'],
                    'last_sort_result' => $bin['last_sort_result'],
                    'sensor_error' => $bin['sensor_error'],
                    'battery' => $bin['battery'],
                    'is_active' => $bin['is_active'],
                    'homebase_id' => $bin['homebase_id'],
                    'task_status' => $bin['task_status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Bins seeded.');
    }
}