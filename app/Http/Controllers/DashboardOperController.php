<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homebase;
use App\Models\Bin;
use App\Models\Notification;
use App\Models\Peringatan;

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
            $warnings = Bin::query()->needsAttention()->get()->map(function ($bin) {
                $label = $bin->name ?? "Bin #{$bin->bin_id}";

                if ($bin->isFull()) {
                    return (object) [
                        'type'     => 'capacity',
                        'priority' => 'high',
                        'title'    => "{$label} Penuh!",
                        'message'  => "Organik {$bin->organic_capacity}% / Anorganik {$bin->anorganic_capacity}%. Segera kosongkan di {$bin->location}.",
                        'time'     => $bin->updated_at?->diffForHumans() ?? 'Baru saja',
                    ];
                }

                return (object) [
                    'type'     => 'battery',
                    'priority' => 'medium',
                    'title'    => "{$label} Baterai Rendah",
                    'message'  => "Baterai {$bin->battery}% di {$bin->location}.",
                    'time'     => $bin->updated_at?->diffForHumans() ?? 'Baru saja',
                ];
            });
        }

        return view('operator.dashboard', compact('homebases', 'warnings'));
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
        $userId = session('user')['id'];

        $notifications = Notification::forOperator($userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Tandai semua sebagai sudah dilihat setelah halaman dibuka
        Notification::forOperator($userId)->unread()->update(['is_new' => false]);

        return view('operator.notifikasi', compact('notifications'));
    }

    // TASK UPDATE
    public function taskUpdate()
    {
        $userId = session('user')['id'];

        // Tampilkan task milik operator ini, pending & in_progress duluan
        $tasks = Notification::forOperator($userId)
            ->tasks()
            ->orderBy('task_status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('operator.taskupdate', compact('tasks'));
    }

    public function startTask(string $id)
    {
        $task = Notification::findOrFail($id);
        $this->authorizeTask($task);

        $task->markInProgress();

        return response()->json([
            'success' => true,
            'message' => 'Task dimulai.',
            'status'  => $task->task_status,
        ]);
    }

    public function completeTask(Request $request, string $id)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $task = Notification::findOrFail($id);
        $this->authorizeTask($task);

        $task->markDone($request->input('notes', ''));

        return response()->json([
            'success' => true,
            'message' => 'Task selesai.',
            'status'  => $task->task_status,
        ]);
    }

    // PRIVATE HELPERS
    private function authorizeTask(Notification $task): void
    {
        if ($task->assigned_to !== session('user')['id']) {
            abort(403, 'Akses ditolak.');
        }
    }
}