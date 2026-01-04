<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Homebase;
use App\Models\Vacuum;
use App\Models\Notification;
use App\Models\Bin;

class DashboardOperController extends Controller
{
    /**
     * Dashboard Operator - Halaman Utama
     */
    public function index()
    {
        // Ambil semua homebase dengan relasi vacuums
        $homebases = Homebase::with('vacuums')->get()->map(function($homebase) {
            return [
                'name' => $homebase->name,
                'location' => $homebase->location,
                'status' => $homebase->status,
                'vacuum_assigned' => $homebase->vacuum_assigned,
                'active' => $homebase->vacuums()->where('is_active', true)->count(),
            ];
        });

        // 👇 GENERATE WARNINGS UNTUK OPERATOR (FULL + MAINTENANCE)
        $warnings = [];
        
        // 1. Warning untuk bin yang PENUH (status = Full ATAU capacity >= 85%)
        $fullBins = Bin::where(function($query) {
            $query->where('status', 'Full')
                  ->orWhere('capacity', '>=', 85);
        })->where('status', '!=', 'Maintenance') // Exclude maintenance dari full
          ->get();
        
        foreach ($fullBins as $bin) {
            $warnings[] = [
                'type' => 'critical',
                'title' => ($bin->name ?? "Bin #{$bin->bin_id}") . ' Penuh',
                'message' => 'Segera kosongkan ' . ($bin->name ?? "Bin #{$bin->bin_id}") . ' di ' . $bin->location . '. Kapasitas sudah mencapai ' . $bin->capacity . '%.'
            ];
        }

        // 2. Warning untuk bin yang sedang MAINTENANCE
        $maintenanceBins = Bin::where('status', 'Maintenance')->get();
        
        foreach ($maintenanceBins as $bin) {
            $warnings[] = [
                'type' => 'info',
                'title' => 'Maintenance - ' . ($bin->name ?? "Bin #{$bin->bin_id}"),
                'message' => ($bin->name ?? "Bin #{$bin->bin_id}") . ' di ' . $bin->location . ' sedang dalam maintenance. Harap periksa status.'
            ];
        }

        // Hitung pending tasks dari warnings yang ada
        $pendingTasks = count($warnings);

        return view('operator.dashboard', compact('homebases', 'warnings', 'pendingTasks'));
    }

    /**
     * Halaman Vacuum Bin - List semua vacuum
     */
    public function vacuumbin()
    {
        // Ambil semua vacuum dengan homebase
        $vacuums = Vacuum::with('homebase')->get()->map(function($vacuum) {
            return (object)[
                'code' => $vacuum->code,
                'name' => $vacuum->name,
                'location' => $vacuum->location,
                'capacity' => $vacuum->capacity,
                'battery' => $vacuum->battery,
                'status' => $vacuum->status_label,
                'updated_at' => $vacuum->updated_at
            ];
        });

        return view('operator.vacuumbin', compact('vacuums'));
    }

    /**
     * Halaman Notifikasi (Cuma dari Bins Real-time)
     */
    public function notifikasi()
    {
        $notifikasis = [];
        
        // 1. Notifikasi dari Bins yang PENUH (Real-time)
        $fullBins = Bin::where(function($query) {
            $query->where('status', 'Full')
                  ->orWhere('capacity', '>=', 85);
        })->where('status', '!=', 'Maintenance')
          ->get();
        
        foreach ($fullBins as $bin) {
            $notifikasis[] = (object)[
                'title' => ($bin->name ?? "Bin #{$bin->bin_id}") . ' Penuh',
                'is_new' => true,
                'source' => 'System',
                'datetime' => now()->format('Y-m-d H:i'),
                'message' => 'Segera kosongkan bin di ' . $bin->location . '. Kapasitas sudah mencapai ' . $bin->capacity . '%.',
                'type' => 'critical',
                'has_check' => true
            ];
        }
        
        // 2. Notifikasi dari Bins yang MAINTENANCE (Real-time)
        $maintenanceBins = Bin::where('status', 'Maintenance')->get();
        
        foreach ($maintenanceBins as $bin) {
            $notifikasis[] = (object)[
                'title' => 'Maintenance - ' . ($bin->name ?? "Bin #{$bin->bin_id}"),
                'is_new' => true,
                'source' => 'Admin',
                'datetime' => now()->format('Y-m-d H:i'),
                'message' => 'Bin di ' . $bin->location . ' sedang dalam maintenance. Harap periksa status.',
                'type' => 'info',
                'has_check' => true
            ];
        }
        
        // Convert ke collection (TANPA gabung notifikasi manual)
        $notifikasis = collect($notifikasis);

        return view('operator.notifikasi', compact('notifikasis'));
    }

    /**
     * Halaman Task Update
     */
    public function taskUpdate()
    {
        // Ambil notifikasi yang jadi task (has_check = true)
        $tasks = Notification::where('has_check', true)
            ->with('homebase')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($notif) {
                return (object)[
                    '_id' => $notif->_id,
                    'status' => $notif->is_new ? 'active' : 'resolved',
                    'type' => $notif->type,
                    'message' => $notif->message,
                    'created_at' => $notif->created_at,
                    'homebase' => (object)[
                        'nama_lokasi' => $notif->homebase->name ?? 'Unknown',
                        'kode_bin' => $notif->vacuum_code ?? '-'
                    ]
                ];
            });

        return view('operator.taskupdate', compact('tasks'));
    }

    /**
     * Start Task - Operator mulai mengerjakan task
     */
    public function startTask($id)
    {
        $notification = Notification::find($id);
        
        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);
        }

        // Update status jadi in progress
        $notification->is_new = true;
        $notification->save();

        return response()->json([
            'success' => true,
            'message' => 'Baik, selamat mengerjakan 😊',
            'status' => 'in_progress'
        ]);
    }

    /**
     * Complete Task - Operator selesai mengerjakan task
     */
    public function completeTask($id)
    {
        $notification = Notification::find($id);
        
        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);
        }

        // Mark as resolved
        $notification->is_new = false;
        $notification->save();

        return response()->json([
            'success' => true,
            'message' => 'Task selesai dikerjakan',
            'status' => 'resolved'
        ]);
    }
}