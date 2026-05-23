<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Homebase;
use App\Models\Vacuum; // Kembali menggunakan Vacuum
use App\Models\Notification;

class DashboardOperController extends Controller
{
    public function index()
    {
        // Menggunakan relasi vacuums sesuai kode awal
        $homebases = Homebase::with('vacuums')->get()->map(function($homebase) {
            return [
                'name' => $homebase->name,
                'location' => $homebase->location,
                'status' => $homebase->status,
                'vacuum_assigned' => $homebase->vacuum_assigned,
                'active' => $homebase->vacuums()->where('is_active', true)->count(),
            ];
        });

        $warnings = [];
        $fullVacuums = Vacuum::where(function($query) {
            $query->where('status', 'Full')
                  ->orWhere('capacity', '>=', 85);
        })->where('status', '!=', 'Maintenance')->get();
        
        foreach ($fullVacuums as $v) {
            $warnings[] = [
                'type' => 'critical',
                'title' => ($v->name ?? "Vacuum #{$v->vacuum_code}") . " Penuh!",
                'message' => "Kapasitas {$v->capacity}%. Segera kosongkan di {$v->location}.",
                'time' => $v->updated_at ? $v->updated_at->diffForHumans() : 'Baru saja'
            ];
        }

        return view('operator.dashboard', compact('homebases', 'warnings'));
    }

    public function vacuumbin()
    {
        $vacuums = Vacuum::all();
        return view('operator.vacuumbin', compact('vacuums'));
    }

    public function notifikasi()
    {
        $notifications = Notification::where('is_new', true)->orderBy('created_at', 'desc')->get();
        return view('operator.notifikasi', compact('notifications'));
    }
}