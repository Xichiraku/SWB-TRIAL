<?php

namespace App\Http\Controllers;

use App\Models\Homebase;
use App\Models\Vacuum;
use App\Models\Peringatan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardOperController extends Controller
{
    public function index()
    {
        $homebases = Homebase::with('vacuums')->get();
        $peringatans = Peringatan::active()
                      ->orderBy('priority', 'desc')
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        $taskCount = $peringatans->count();
        $greeting = $this->getGreeting();
        $currentDate = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y');
        
        return view('operator.dashboard', compact(
            'homebases', 
            'peringatans', 
            'taskCount', 
            'greeting', 
            'currentDate'
        ));
    }

    private function getGreeting()
    {
        $hour = Carbon::now()->format('H');
        
        if ($hour >= 5 && $hour < 11) {
            return 'Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            return 'Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            return 'Sore';
        } else {
            return 'Malam';
        }
    }

    public function resolvePeringatan($id)
    {
        try {
            $peringatan = Peringatan::findOrFail($id);
            $peringatan->update(['status' => 'resolved']);

            return response()->json([
                'success' => true,
                'message' => 'Peringatan berhasil diselesaikan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function vacuumbin()
    {
        $vacuums = Vacuum::with('homebase')->get();
        $greeting = $this->getGreeting();
        $currentDate = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y');
        
        $totalVacuums = $vacuums->count();
        $activeVacuums = $vacuums->where('status', 'active')->count();
        $fullCapacity = $vacuums->where('capacity', '>=', 90)->count();
        $lowBattery = $vacuums->where('battery_level', '<=', 30)->count();
        
        return view('operator.vacuumbin', compact(
            'vacuums',
            'greeting',
            'currentDate',
            'totalVacuums',
            'activeVacuums',
            'fullCapacity',
            'lowBattery'
        ));
    }

    public function emptyVacuum($id)
    {
        try {
            $vacuum = Vacuum::findOrFail($id);
            $vacuum->update(['capacity' => 0]);

            Peringatan::where('vacuum_code', $vacuum->code)
                      ->where('type', 'capacity')
                      ->where('status', 'active')
                      ->update(['status' => 'resolved']);

            return response()->json([
                'success' => true,
                'message' => 'Vacuum berhasil dikosongkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function notifikasi() 
    {
        $peringatans = Peringatan::with('homebase')
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        $greeting = $this->getGreeting();
        $currentDate = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y');
        
        $totalPeringatans = $peringatans->count();
        $activePeringatans = $peringatans->where('status', 'active')->count();
        $highPriority = $peringatans->where('priority', 'high')->where('status', 'active')->count();
        $resolvedToday = $peringatans->where('status', 'resolved')
                                     ->whereBetween('updated_at', [
                                         Carbon::today(),
                                         Carbon::tomorrow()
                                     ])->count();
        
        return view('operator.notifikasi', compact(
            'peringatans',
            'greeting',
            'currentDate',
            'totalPeringatans',
            'activePeringatans',
            'highPriority',
            'resolvedToday'
        ));
    }

    public function taskUpdate()
{
    // Ambil semua task dari peringatan yang statusnya active atau resolved
    $tasks = Peringatan::with('homebase')
                      ->whereIn('status', ['active', 'resolved'])
                      ->orderBy('created_at', 'desc')
                      ->get();
    
    $greeting = $this->getGreeting();
    $currentDate = Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y');
    
    // Statistik
    $pendingTasks = $tasks->where('status', 'active')->count();
    $doneTasks = $tasks->where('status', 'resolved')->count();
    
    return view('operator.taskupdate', compact(
        'tasks',
        'greeting',
        'currentDate',
        'pendingTasks',
        'doneTasks'
    ));
}

public function startTask($id)
{
    try {
        $task = Peringatan::findOrFail($id);
        $task->update(['status' => 'in_progress']);

        return response()->json([
            'success' => true,
            'message' => 'Task dimulai'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

public function completeTask($id)
{
    try {
        $task = Peringatan::findOrFail($id);
        $task->update(['status' => 'resolved']);

        return response()->json([
            'success' => true,
            'message' => 'Task selesai'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
}