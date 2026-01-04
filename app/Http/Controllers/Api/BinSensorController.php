<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bin;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class BinSensorController extends Controller
{
    /**
     * Terima data dari ESP32 sensor
     * Method: POST
     * Endpoint: /api/bins/update-sensor
     */
   public function updateFromSensor(Request $request)
{
    Log::info('📥 Data dari ESP32:', $request->all());

    $validated = $request->validate([
        'bin_id' => 'required|string',
        'status' => 'required|in:Normal,Full',
        'capacity' => 'required|integer|min:0|max:100'
    ]);

    try {
        // 🔒 HANYA BIN 001 yang bisa diupdate dari sensor
        if ($validated['bin_id'] !== '001') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya BIN 001 yang terhubung dengan sensor'
            ], 403);
        }

        // Cari BIN dengan bin_id = '001'
        $bin = Bin::where('bin_id', '001')->first();
        
        if (!$bin) {
            return response()->json([
                'success' => false,
                'message' => 'BIN 001 tidak ditemukan'
            ], 404);
        }

        $oldStatus = $bin->status;
        $oldCapacity = $bin->capacity;
        
        // Update real-time
        $bin->status = $validated['status'];
        $bin->capacity = $validated['capacity'];
        $bin->last_updated = now();
        $bin->save();

        Log::info("✅ BIN 001 updated: {$oldStatus} → {$bin->status}");

        // Buat notifikasi kalau jadi Full
        $notificationCreated = false;

        if ($validated['status'] === 'Full' && $oldStatus !== 'Full') {
            $this->createNotificationForOperators($bin, 'bin_full');
            $notificationCreated = true;
        }

        if ($validated['capacity'] >= 85 && $oldCapacity < 85) {
            $this->createNotificationForOperators($bin, 'bin_almost_full');
            $notificationCreated = true;
        }

        return response()->json([
            'success' => true,
            'message' => 'BIN 001 updated',
            'data' => [
                'bin_id' => $bin->bin_id,
                'name' => $bin->name,
                'status' => $bin->status,
                'capacity' => $bin->capacity,
                'notification_created' => $notificationCreated
            ]
        ], 200);

    } catch (\Exception $e) {
        Log::error('❌ Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

private function createNotificationForOperators($bin, $type)
{
    if ($type === 'bin_full') {
        $title = $bin->name . ' Penuh!';
        $message = "Segera kosongkan {$bin->name} di {$bin->location}. Kapasitas {$bin->capacity}%.";
        $notifType = 'critical';
    } else {
        $title = $bin->name . ' Hampir Penuh';
        $message = "{$bin->name} di {$bin->location} hampir penuh ({$bin->capacity}%).";
        $notifType = 'warning';
    }

    Notification::create([
        'title' => $title,
        'message' => $message,
        'type' => $notifType,
        'source' => 'IoT Sensor',
        'is_new' => true,
        'has_check' => true,
        'vacuum_code' => $bin->bin_id,
        'homebase_id' => $bin->homebase_id,
        'created_at' => now()
    ]);

    Log::info("🔔 Notifikasi: {$title}");
}
}