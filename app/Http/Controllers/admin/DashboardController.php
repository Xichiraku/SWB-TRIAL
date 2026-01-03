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

    // --- BAGIAN YANG DITAMBAHKAN (MISSING) ---
    // Fungsi ini wajib ada untuk menangani route: /admin/bin/{code}
    public function detail($code)
    {
        // Cari bin berdasarkan code, jika tidak ada tampilkan 404
        $bin = Bin::where('code', $code)->firstOrFail();

        // Tentukan Status Text, Warna Badge, dan Icon untuk halaman detail
        $statusText = 'Normal';
        $statusBadgeClass = 'bg-green-100 text-green-700';
        $statusIcon = 'check-circle';

        if ($bin->status === 'maintenance') {
            $statusText = 'Maintenance';
            $statusBadgeClass = 'bg-orange-100 text-orange-700';
            $statusIcon = 'wrench';
        } elseif ($bin->capacity >= 85) {
            $statusText = 'Full';
            $statusBadgeClass = 'bg-red-100 text-red-700';
            $statusIcon = 'alert-triangle';
        }

        return view('admin.pages.bindetail', compact('bin', 'statusText', 'statusBadgeClass', 'statusIcon'));
    }

    // API: Get all bins data
    public function getBins(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        // Menggunakan Bin::query() agar data maintenance tetap terambil
        $query = Bin::query(); 
        
        if ($filter !== 'all') {
            $query->byStatus($filter);
        }
        
        $rawBins = $query->orderBy('code', 'asc')->get();

        $bins = $rawBins->map(function($bin) {
            
            // --- LOGIKA STATUS TEXT (Perbaikan di sini) ---
            $statusText = 'Normal';
            
            // 1. Cek Maintenance
            if ($bin->status === 'maintenance') {
                $statusText = 'Maintenance';
            } 
            // 2. Cek Kapasitas (UBAH 'Penuh' JADI 'Full')
            elseif ($bin->capacity >= 85) {
                $statusText = 'Full'; 
            }

            // --- LOGIKA WARNA ---
            $color = 'green';
            if ($statusText === 'Full') $color = 'red';       // Sesuaikan dengan 'Full'
            if ($statusText === 'Maintenance') $color = 'orange';

            return [
                'bin_id'   => $bin->code, 
                'battery'  => $bin->battery_level,   
                'capacity' => $bin->capacity,
                
                // Kirim 'Full' agar frontend memunculkan badge merah
                'status'   => $statusText,
                'color'    => $color,
                
                // Fallback lokasi jika kosong
                'location' => $bin->location ?? $bin->homebase_id,
                'name'     => 'Smart Bin ' . $bin->code,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $bins,
            'stats' => [
                'total' => Bin::count(), 
                'full' => Bin::where('capacity', '>=', 85)->where('status', '!=', 'maintenance')->count(),
                'normal' => Bin::where('capacity', '<', 85)->where('status', '!=', 'maintenance')->count(),
                'maintenance' => Bin::where('status', 'maintenance')->count()
            ]
        ]);
    }

    // API: Dashboard statistics
    public function getStats()
    {
        $bins = Bin::active()->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_bins' => $bins->count(),
                
                // Logika hitung manual karena status di DB cuma "active"
                'full_bins' => $bins->where('capacity', '>=', 85)->count(),
                'normal_bins' => $bins->where('capacity', '<', 85)->count(),
                'maintenance_bins' => $bins->where('status', 'maintenance')->count(),
                
                'average_capacity' => round($bins->avg('capacity'), 1),
                
                // UBAH: 'battery' jadi 'battery_level' sesuai database
                'average_battery' => round($bins->avg('battery_level'), 1),
                
                // Logic Needs Attention: Penuh atau Baterai Low (< 20%)
                'needs_attention' => $bins->filter(function($bin) {
                    return $bin->capacity >= 85 || $bin->battery_level <= 20;
                })->count(),
                
                'last_updated' => now()->format('H:i:s')
            ]
        ]);
    }

    // API: Update bin status
    public function updateBinStatus(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string', // UBAH: bin_id jadi code
            'capacity' => 'required|integer|min:0|max:100',
            'battery_level' => 'required|integer|min:0|max:100', // UBAH: battery jadi battery_level
            'status' => 'nullable|string'
        ]);

        // Logic auto status update
        if (!isset($validated['status'])) {
            if ($validated['capacity'] >= 85) {
                $validated['status'] = 'active'; // Atau biarkan active
            }
        }

        $validated['updated_at'] = now();

        // Cari berdasarkan 'code'
        $bin = Bin::where('code', $validated['code'])->first();

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