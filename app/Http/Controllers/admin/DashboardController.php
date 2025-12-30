<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek session
        if (!session('user')) {
            return redirect('/');
        }
        
        // Tampilkan dashboard
        return view('admin.pages.dashboard');
    }

    // API: Get all bins data (untuk real-time update)
    public function getBins(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        $query = Bin::active();
        
        if ($filter !== 'all') {
            $query->byStatus($filter);
        }
        
        $bins = $query->orderBy('bin_id')->get();

        return response()->json([
            'success' => true,
            'data' => $bins,
            'stats' => [
                'total' => Bin::active()->count(),
                'full' => Bin::active()->byStatus('Full')->count(),
                'normal' => Bin::active()->byStatus('Normal')->count(),
                'maintenance' => Bin::active()->byStatus('Maintenance')->count()
            ]
        ]);
    }

    // API: Get dashboard statistics
    public function getStats()
    {
        $bins = Bin::active()->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_bins' => $bins->count(),
                'full_bins' => $bins->where('status', 'Full')->count(),
                'normal_bins' => $bins->where('status', 'Normal')->count(),
                'maintenance_bins' => $bins->where('status', 'Maintenance')->count(),
                'average_capacity' => round($bins->avg('capacity'), 1),
                'average_battery' => round($bins->avg('battery'), 1),
                'needs_attention' => $bins->filter->needsAttention()->count(),
                'last_updated' => now()->format('H:i:s')
            ]
        ]);
    }

    // API: Update bin status (untuk sensor nanti)
    public function updateBinStatus(Request $request)
    {
        $validated = $request->validate([
            'bin_id' => 'required|string',
            'capacity' => 'required|integer|min:0|max:100',
            'battery' => 'required|integer|min:0|max:100',
            'status' => 'nullable|string|in:Full,Normal,Maintenance'
        ]);

        // Determine status based on capacity if not provided
        if (!isset($validated['status'])) {
            if ($validated['capacity'] >= 85) {
                $validated['status'] = 'Full';
            } else {
                $validated['status'] = 'Normal';
            }
        }

        $validated['last_updated'] = now();

        $bin = Bin::where('bin_id', $validated['bin_id'])->first();

        if ($bin) {
            $bin->update($validated);
        } else {
            $bin = Bin::create($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bin status updated successfully',
            'data' => $bin
        ]);
    }
}