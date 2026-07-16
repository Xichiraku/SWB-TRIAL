<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomebaseSeeder extends Seeder
{
    public function run(): void
    {
        $homebases = [
            [
                'name' => 'Taman Ormawa',
                'location' => 'Politeknik Batam',
                'status' => 'Online',
                'vacuum_assigned' => 4,
                'active_vacuums' => 3,
                'temperature' => 24,
                'power_status' => 'Normal',
            ],
            [
                'name' => 'Halaman Gedung Utama',
                'location' => 'Politeknik Batam',
                'status' => 'Online',
                'vacuum_assigned' => 3,
                'active_vacuums' => 2,
                'temperature' => 22,
                'power_status' => 'Normal',
            ],
        ];

        foreach ($homebases as $homebase) {
            DB::table('homebases')->updateOrInsert(
                ['name' => $homebase['name']],
                [
                    'location' => $homebase['location'],
                    'status' => $homebase['status'],
                    'vacuum_assigned' => $homebase['vacuum_assigned'],
                    'active_vacuums' => $homebase['active_vacuums'],
                    'temperature' => $homebase['temperature'],
                    'power_status' => $homebase['power_status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Homebases seeded.');
    }
}
