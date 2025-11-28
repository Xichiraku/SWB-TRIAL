<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BinController extends Controller
{
    public function show($id)
    {
        // Cek apakah user sudah login
        if (!session()->has('user')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu');
        }

        // Data dummy untuk bin (nanti ganti dengan database)
        $bins = [
            '001' => [
                'id' => '001',
                'name' => 'Bin #001',
                'location' => 'Main Street Park',
                'status' => 'Full',
                'battery' => 78,
                'capacity' => 85,
                'last_emptied' => '2025-01-20 14:30',
                'solar_status' => 'Active',
                'daily_energy' => '2.4 kWh',
                'efficiency' => '85%',
                'motor_status' => 'Online',
                'suction_power' => '92%',
                'filter_status' => 'Clean'
            ],
            '002' => [
                'id' => '002',
                'name' => 'Bin #002',
                'location' => 'City Center',
                'status' => 'Normal',
                'battery' => 92,
                'capacity' => 45,
                'last_emptied' => '2025-01-19 10:15',
                'solar_status' => 'Active',
                'daily_energy' => '3.1 kWh',
                'efficiency' => '90%',
                'motor_status' => 'Online',
                'suction_power' => '88%',
                'filter_status' => 'Clean'
            ],
            '003' => [
                'id' => '003',
                'name' => 'Bin #003',
                'location' => 'Shopping Mall',
                'status' => 'Empty',
                'battery' => 65,
                'capacity' => 12,
                'last_emptied' => '2025-01-21 08:00',
                'solar_status' => 'Active',
                'daily_energy' => '2.8 kWh',
                'efficiency' => '82%',
                'motor_status' => 'Online',
                'suction_power' => '95%',
                'filter_status' => 'Clean'
            ],
        ];

        // Cek apakah bin dengan ID tersebut ada
        if (!isset($bins[$id])) {
            return redirect()->back()->with('error', 'Bin tidak ditemukan');
        }

        $bin = $bins[$id];
        $userRole = session('user')['role'];

        return view('bin.detail', compact('bin', 'userRole'));
    }
}