<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Homebase;
use App\Models\Vacuum;
use App\Models\Notification;

class OperatorSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        Homebase::truncate();
        Vacuum::truncate();
        Notification::truncate();

        // ============ CREATE HOMEBASES ============
        $homebase1 = Homebase::create([
            'name' => 'Taman Ormawa',
            'location' => 'Politeknik Batam',
            'status' => 'Online',
            'vacuum_assigned' => 4,
            'active_vacuums' => 3,
            'temperature' => 24,
            'power_status' => 'Normal'
        ]);

        $homebase2 = Homebase::create([
            'name' => 'Halaman Gedung Utama',
            'location' => 'Politeknik Batam',
            'status' => 'Online',
            'vacuum_assigned' => 3,
            'active_vacuums' => 2,
            'temperature' => 22,
            'power_status' => 'Normal'
        ]);

        // ============ CREATE VACUUMS ============
        // Vacuums untuk Homebase 1
        Vacuum::create([
            'code' => 'VB001',
            'name' => 'Vacuum VB001',
            'homebase_id' => $homebase1->_id,
            'location' => 'Taman Ormawa',
            'capacity' => 95,
            'battery' => 35,
            'status' => 'active',
            'is_active' => true
        ]);

        Vacuum::create([
            'code' => 'VB002',
            'name' => 'Vacuum VB002',
            'homebase_id' => $homebase1->_id,
            'location' => 'Taman Ormawa',
            'capacity' => 45,
            'battery' => 40,
            'status' => 'active',
            'is_active' => true
        ]);

        Vacuum::create([
            'code' => 'VB005',
            'name' => 'Vacuum VB005',
            'homebase_id' => $homebase1->_id,
            'location' => 'Taman Ormawa',
            'capacity' => 30,
            'battery' => 85,
            'status' => 'active',
            'is_active' => true
        ]);

        Vacuum::create([
            'code' => 'VB006',
            'name' => 'Vacuum VB006',
            'homebase_id' => $homebase1->_id,
            'location' => 'Taman Ormawa',
            'capacity' => 20,
            'battery' => 90,
            'status' => 'inactive',
            'is_active' => false
        ]);

        // Vacuums untuk Homebase 2
        Vacuum::create([
            'code' => 'VB003',
            'name' => 'Vacuum VB003',
            'homebase_id' => $homebase2->_id,
            'location' => 'Halaman Gedung Utama',
            'capacity' => 60,
            'battery' => 80,
            'status' => 'active',
            'is_active' => true
        ]);

        Vacuum::create([
            'code' => 'VB004',
            'name' => 'Vacuum VB004',
            'homebase_id' => $homebase2->_id,
            'location' => 'Halaman Gedung Utama',
            'capacity' => 30,
            'battery' => 90,
            'status' => 'active',
            'is_active' => true
        ]);

        Vacuum::create([
            'code' => 'VB007',
            'name' => 'Vacuum VB007',
            'homebase_id' => $homebase2->_id,
            'location' => 'Halaman Gedung Utama',
            'capacity' => 25,
            'battery' => 70,
            'status' => 'inactive',
            'is_active' => false
        ]);

        // ============ CREATE NOTIFICATIONS ============
        Notification::create([
            'title' => 'Vacuum VB001 Penuh',
            'message' => 'Segera kosongkan vacuum bin VB001 di Taman Ormawa. Kapasitas sudah mencapai 95%.',
            'type' => 'critical',
            'source' => 'Admin',
            'is_new' => true,
            'has_check' => true,
            'vacuum_code' => 'VB001',
            'homebase_id' => $homebase1->_id
        ]);

        Notification::create([
            'title' => 'Baterai Rendah',
            'message' => 'Vacuum VB002 memiliki baterai rendah (40%). Harap periksa panel solar.',
            'type' => 'warning',
            'source' => 'System',
            'is_new' => true,
            'has_check' => false,
            'vacuum_code' => 'VB002',
            'homebase_id' => $homebase1->_id
        ]);

        Notification::create([
            'title' => 'Maintenance Terjadwal',
            'message' => 'Vacuum VB003 memerlukan maintenance rutin minggu ini.',
            'type' => 'info',
            'source' => 'Admin',
            'is_new' => false,
            'has_check' => true,
            'vacuum_code' => 'VB003',
            'homebase_id' => $homebase2->_id
        ]);

        echo "✅ Seeder berhasil! Data homebase, vacuum, dan notification sudah dibuat.\n";
    }
}