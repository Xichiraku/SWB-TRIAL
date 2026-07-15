<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bin;
use App\Models\HistoryLog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BinSensorController extends Controller
{
    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'API sensor aktif, siap menerima data ESP32',
            'server_time' => now()->toDateTimeString(),
        ]);
    }


    public function updateFromSensor(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',

            'bins' => 'required|array|min:1',

            'bins.*.bin_id' => 'required|string',

            'bins.*.type' => 'required|string|in:basah,kering',

            'bins.*.distance_cm' => 'required|numeric',

            'bins.*.sensor_ok' => 'required|boolean',

            // ===== YL-69 =====
            'bins.*.moisture' => 'required|integer|min:0|max:4095',
            'bins.*.moisture_percent' => 'required|integer|min:0|max:100',
            'bins.*.moisture_status' => 'required|string',
            'bins.*.last_sort_result' => 'required|string|in:Basah,Kering',
        ]);

        $updated = [];
        $skipped = [];

        foreach ($validated['bins'] as $data) {

            $bin = Bin::where('bin_id', $data['bin_id'])->first();

            if (!$bin) {

                $skipped[] = $data['bin_id'];

                Log::warning("Bin tidak ditemukan", $data);

                continue;
            }

            $update = [

                'device_id' => $validated['device_id'],

                'last_seen_at' => now(),

                'sensor_error' => !$data['sensor_ok'],
                'distance_cm' => $data['distance_cm'],

                // ====== DATA YL69 ======
                'moisture' => $data['moisture'],

                'moisture_percent' => $data['moisture_percent'],

                'moisture_status' => $data['moisture_status'],

                'last_sort_result' => $data['last_sort_result'],

            ];

            if ($data['sensor_ok']) {

                $tankHeight = $bin->tank_height_cm ?? 30;

                $distance = $data['distance_cm'];

                $capacity = (($tankHeight - $distance) / $tankHeight) * 100;

                $capacity = max(0, min(100, round($capacity)));

                $update['capacity'] = $capacity;
            }

            $bin->update($update);
           // =====================================
// SIMPAN ACTIVITY LOG
// =====================================

// =====================================
// EVENT 1 : SENSOR ERROR
// =====================================

if (!$data['sensor_ok']) {

    HistoryLog::create([

        'bin_id' => $bin->bin_id,

        'bin_name' => $bin->name,

        'homebase_id' => $bin->homebase_id,

        'status' => 'Maintenance',

        'message' => 'HC-SR04 sensor not responding.',

        'triggered_by' => 'ESP32',

    ]);

   $operator = User::where('role', 'operator')->first();

if ($operator) {

    $exists = Notification::where('bin_code', $bin->bin_id)
        ->where('task_status', 'pending')
        ->exists();

    if (!$exists) {

        Notification::create([

            'title' => 'Maintenance Required',

            'message' => 'HC-SR04 sensor not responding.',

            'type' => 'task',

            'source' => 'system',

            'is_new' => true,

            'has_check' => false,

            'bin_code' => $bin->bin_id,

            'assigned_to' => $operator->_id,

            'task_status' => 'pending',

        ]);

    }

}

}

// =====================================
// EVENT 2 : BIN FULL
// =====================================

if (($update['capacity'] ?? 0) >= 85 && !$bin->full_logged) {

    HistoryLog::create([

        'bin_id' => $bin->bin_id,

        'bin_name' => $bin->name,

        'homebase_id' => $bin->homebase_id,

        'status' => 'Full',

        'message' => 'Bin capacity reached '.$update['capacity'].'%',

        'triggered_by' => 'ESP32',

    ]);

    $operator = User::where('role', 'operator')->first();

if ($operator) {

    $exists = Notification::where('bin_code', $bin->bin_id)
        ->where('task_status', 'pending')
        ->exists();

    if (!$exists) {

        Notification::create([

            'title' => 'Bin Full',

            'message' => 'Capacity reached '.$update['capacity'].'%. Please empty the bin.',

            'type' => 'task',

            'source' => 'system',

            'is_new' => true,

            'has_check' => false,

            'bin_code' => $bin->bin_id,

            'assigned_to' => $operator->_id,

            'task_status' => 'pending',

        ]);

    }

}

    $bin->update([
    'full_logged' => true,
    'task_status' => 'pending'
]);
}

// Kalau sudah tidak penuh lagi
if (($update['capacity'] ?? 0) < 85 && $bin->full_logged) {

   $bin->update([
    'full_logged' => false,
    'task_status' => null
]);

}

$shouldCreateHistory = false;

if (
    $data['last_sort_result'] == 'Basah' &&
    $bin->type == 'basah'
) {
    $shouldCreateHistory = true;
}

if (
    $data['last_sort_result'] == 'Kering' &&
    $bin->type == 'kering'
) {
    $shouldCreateHistory = true;
}

if ($shouldCreateHistory) {

    HistoryLog::create([

        'bin_id' => $bin->bin_id,

        'bin_name' => $bin->name,

        'homebase_id' => $bin->homebase_id,

        'status' => 'Success',

        'message' => $data['last_sort_result'] == 'Basah'
            ? 'Waste sorted into Wet Bin'
            : 'Waste sorted into Dry Bin',

        'triggered_by' => 'ESP32',

    ]);

    

}
            $updated[] = [

                'bin_id' => $bin->bin_id,

                'distance_cm' => $bin->distance_cm,

                'capacity' => $bin->capacity,

                'moisture' => $bin->moisture,

                'moisture_percent' => $bin->moisture_percent,

                'moisture_status' => $bin->moisture_status,

                'last_sort_result' => $bin->last_sort_result,

            ];
        }

        return response()->json([

            'success' => true,

            'message' => 'Sensor berhasil diupdate',

            'updated' => $updated,

            'skipped' => $skipped,

            'server_time' => now(),

        ]);
    }
}