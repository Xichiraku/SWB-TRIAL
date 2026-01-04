<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('user')) {
            return redirect('/');
        }
        return view('admin.pages.dashboard');
    }

    // Detail Bin
    public function detail($code)
    {
        // Cari bin berdasarkan bin_id (bukan code)
        $bin = Bin::where('bin_id', $code)->firstOrFail();

        // Tentukan Status
        $statusText = 'Normal';
        $statusBadgeClass = 'bg-green-100 text-green-700';
        $statusIcon = 'check-circle';

        if ($bin->status === 'Maintenance') {
            $statusText = 'Maintenance';
            $statusBadgeClass = 'bg-orange-100 text-orange-700';
            $statusIcon = 'wrench';
        } elseif ($bin->status === 'Full' || $bin->capacity >= 85) {
            $statusText = 'Full';
            $statusBadgeClass = 'bg-red-100 text-red-700';
            $statusIcon = 'alert-triangle';
        }

        return view('admin.pages.bindetail', compact('bin', 'statusText', 'statusBadgeClass', 'statusIcon'));
    }

    // API: Get Bins
    public function getBins(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = Bin::query(); 
        
        // Apply filter
        if ($filter === 'Full') {
            $query->where(function($q) {
                $q->where('status', 'Full')
                  ->orWhere('capacity', '>=', 85);
            });
        } elseif ($filter === 'Normal') {
            $query->where('status', 'Normal')
                  ->where('capacity', '<', 85);
        } elseif ($filter === 'Maintenance') {
            $query->where('status', 'Maintenance');
        }
        
        $rawBins = $query->orderBy('bin_id', 'asc')->get();

        // 👇 FIX: Mapping data sesuai struktur database yang benar
        $bins = $rawBins->map(function($bin) {
            // Tentukan status text
            $statusText = 'Normal';
            
            if ($bin->status === 'Maintenance') {
                $statusText = 'Maintenance';
            } elseif ($bin->status === 'Full' || $bin->capacity >= 85) {
                $statusText = 'Full';
            }

            // Tentukan warna
            $color = 'green';
            if ($statusText === 'Full') $color = 'red';
            if ($statusText === 'Maintenance') $color = 'orange';

            return [
                'bin_id'   => $bin->bin_id ?? 'Unknown', // 👈 FIX: Pakai bin_id
                'battery'  => $bin->battery ?? 0, // 👈 FIX: Pakai battery (bukan battery_level)
                'capacity' => $bin->capacity ?? 0,
                'status'   => $statusText,
                'color'    => $color,
                'location' => $bin->location ?? 'Unknown Location',
                'name'     => $bin->name ?? "Bin #{$bin->bin_id}", // 👈 FIX: Pakai field name dari database
            ];
        });

        // Calculate stats - FIXED: Hindari double counting
        $allBins = Bin::all();
        
        // Hitung bins yang penuh (status Full ATAU capacity >= 85, tapi bukan Maintenance)
        $fullBins = $allBins->filter(function($bin) {
            return ($bin->status === 'Full' || $bin->capacity >= 85) 
                   && $bin->status !== 'Maintenance';
        });
        
        return response()->json([
            'success' => true,
            'data' => $bins,
            'stats' => [
                'total' => $allBins->count(), 
                'full' => $fullBins->count(), // 👈 FIX: Pakai filter, bukan double count
                'normal' => $allBins->filter(function($bin) {
                    return $bin->status === 'Normal' && $bin->capacity < 85;
                })->count(),
                'maintenance' => $allBins->where('status', 'Maintenance')->count()
            ]
        ]);
    }

    // API: Dashboard Statistics
    public function getStats()
    {
        $bins = Bin::where('is_active', true)->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_bins' => $bins->count(),
                'full_bins' => $bins->where('capacity', '>=', 85)->count(),
                'normal_bins' => $bins->where('capacity', '<', 85)->count(),
                'maintenance_bins' => $bins->where('status', 'Maintenance')->count(),
                'average_capacity' => round($bins->avg('capacity'), 1),
                'average_battery' => round($bins->avg('battery'), 1), // 👈 FIX: Pakai battery
                'needs_attention' => $bins->filter(function($bin) {
                    return $bin->capacity >= 85 || $bin->battery <= 20;
                })->count(),
                'last_updated' => now()->format('H:i:s')
            ]
        ]);
    }

    // API: Update Bin Status
    public function updateBinStatus(Request $request)
    {
        $validated = $request->validate([
            'bin_id' => 'required|string', // 👈 FIX: Pakai bin_id
            'capacity' => 'required|integer|min:0|max:100',
            'battery' => 'required|integer|min:0|max:100', // 👈 FIX: Pakai battery
            'status' => 'nullable|string'
        ]);

        // Auto update status
        if (!isset($validated['status'])) {
            if ($validated['capacity'] >= 85) {
                $validated['status'] = 'Full';
            } else {
                $validated['status'] = 'Normal';
            }
        }

        $validated['updated_at'] = now();

        // Cari berdasarkan bin_id
        $bin = Bin::where('bin_id', $validated['bin_id'])->first();

        if ($bin) {
            $bin->update($validated);
        } else {
            $bin = Bin::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bin updated',
            'data' => $bin
        ]);
    }
}