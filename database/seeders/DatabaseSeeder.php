<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Homebase;
use App\Models\Vacuum;
use App\Models\Peringatan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Homebase 1: Central Park
        $centralPark = Homebase::create([
            'name' => 'Central park',
            'location' => 'Central Park, Sector A',
            'status' => 'online',
            'vacuum_assigned' => 1,
            'active_vacuums' => 1,
            'temperature' => 28.0,
            'power_status' => 'Normal'
        ]);

        // Seed Homebase 2: Shopping Mall
        $shoppingMall = Homebase::create([
            'name' => 'Shopping Mall Bin',
            'location' => 'City Mall, Food Court',
            'status' => 'online',
            'vacuum_assigned' => 1,
            'active_vacuums' => 1,
            'temperature' => 26.0,
            'power_status' => 'Normal'
        ]);

        // Seed Vacuum untuk Central Park (FULL)
        Vacuum::create([
            'code' => 'VB003',
            'homebase_id' => $centralPark->_id,
            'status' => 'active',
            'battery_level' => 80,
            'capacity' => 95,
            'last_maintenance' => now()->subDays(2)
        ]);

        // Seed Vacuum untuk Shopping Mall (NORMAL)
        Vacuum::create([
            'code' => 'VB001',
            'homebase_id' => $shoppingMall->_id,
            'status' => 'active',
            'battery_level' => 80,
            'capacity' => 67,
            'last_maintenance' => now()->subDays(1)
        ]);

        // Seed Peringatan untuk Central Park
        Peringatan::create([
            'homebase_id' => $centralPark->_id,
            'vacuum_code' => 'VB003',
            'type' => 'capacity',
            'title' => 'Vacuum VB003 Penuh',
            'message' => 'Segera kosongkan vacuum bin VB003 di Central Park. Kapasitas sudah mencapai 95%.',
            'priority' => 'high',
            'status' => 'active'
        ]);

        // Seed Peringatan untuk Shopping Mall (Battery)
        Peringatan::create([
            'homebase_id' => $shoppingMall->_id,
            'vacuum_code' => 'VB001',
            'type' => 'battery',
            'title' => 'Baterai Rendah',
            'message' => 'Vacuum VB001 di Shopping Mall memiliki baterai 80%. Periksa panel solar.',
            'priority' => 'medium',
            'status' => 'active'
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- 2 Homebases (Central Park & Shopping Mall)');
        $this->command->info('- 2 Vacuums (VB003 & VB001)');
        $this->command->info('- 2 Peringatans');
    }
}