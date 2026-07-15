<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homebase;
use App\Models\Bin;
use App\Models\Notification;
use App\Models\Peringatan;
use App\Models\HistoryLog;

class DashboardOperController extends Controller
{
    // OVERVIEW DASHBOARD
    public function index()
    {
        $homebases = Homebase::with('bins')->get()->map(function ($homebase) {
            $bins = $homebase->bins;
            return [
                'name'         => $homebase->name,
                'location'     => $homebase->location,
                'status'       => $homebase->status,
                'bin_assigned' => $bins->count(),
                'active'       => $bins->where('is_active', true)->count(),
            ];
        });

        // Ambil peringatan aktif dari collection peringatans
        $warnings = Peringatan::active()
            ->orderBy('created_at', 'desc')
            ->get();

        if ($warnings->isEmpty()) {
            $warnings = Bin::where(function ($query) {
             $query->where('capacity', '>=', 85)
              ->orWhere('sensor_error', true);
              })->get()->map(function ($bin) {
            $label = $bin->name ?? "Bin #{$bin->bin_id}";

                if ($bin->capacity >= 85) {
                    return (object)[
                    'type' => 'capacity',
                    'priority' => 'high',
                    'title' => "{$label} Full",
                    'message' => "Capacity reached {$bin->capacity}%. Please empty the bin at {$bin->location}.",
                    'time' => $bin->updated_at?->diffForHumans() ?? 'Just now',
                ];
                }

                return (object)[
                    'type' => 'maintenance',
                    'priority' => 'medium',
                    'title' => "{$label} Sensor Error",
                    'message' => "HC-SR04 sensor is not responding.",
                    'time' => $bin->updated_at?->diffForHumans() ?? 'Just now',
                ];
            });
        }

        $bins = Bin::orderBy('updated_at', 'desc')->get();

        return view('operator.dashboard', compact(
            'homebases',
            'warnings',
            'bins'
        ));
        }

    // BIN MONITORING
    public function bins()
    {
        $bins = Bin::with('homebase')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('operator.bins', compact('bins'));
    }

    // NOTIFIKASI
    public function notifikasi()
{
    $notifications = Bin::where(function ($query) {

            $query->where('capacity', '>=', 85)
                  ->orWhere('sensor_error', true);

        })
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('operator.notifikasi', compact('notifications'));
}

    // TASK UPDATE
    public function taskUpdate()
{
    $tasks = Bin::where(function ($query) {

            $query->where('capacity', '>=', 85)
                  ->orWhere('sensor_error', true);

        })
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('operator.taskupdate', compact('tasks'));
}
    public function startTask($id)
{
    $bin = Bin::findOrFail($id);

    $bin->update([
        'task_status' => 'in_progress'
    ]);

    return response()->json([
        'success' => true
    ]);
}

    public function completeTask($id)
{
    $bin = Bin::findOrFail($id);

    $bin->update([

        'capacity' => 0,

        'full_logged' => false,

        'task_status' => 'completed',

        'last_emptied' => now(),

    ]);

    HistoryLog::create([

        'bin_id' => $bin->bin_id,

        'bin_name' => $bin->name,

        'status' => 'Completed',

        'message' => 'Waste collection completed.',

        'triggered_by' => 'Operator'

    ]);

    return response()->json([
        'success'=>true
    ]);
}
}