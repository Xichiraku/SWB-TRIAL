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

    public function detail($code)
    {
        $bin = Bin::where('bin_id', $code)->firstOrFail();

        return view('admin.pages.bindetail', [
            'bin' => $bin,
            'statusText' => $bin->computed_status,
            'statusBadgeClass' => match ($bin->computed_status) {
                'Full' => 'bg-red-100 text-red-700',
                'Maintenance' => 'bg-orange-100 text-orange-700',
                default => 'bg-green-100 text-green-700',
            },
            'statusIcon' => match ($bin->computed_status) {
                'Full' => 'alert-triangle',
                'Maintenance' => 'wrench',
                default => 'check-circle',
            }
        ]);
    }

    public function getBins(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $allBins = Bin::orderBy('bin_id')->get();

        $bins = $allBins->map(function ($bin) {

            return [
                'bin_id' => $bin->bin_id,
                'name' => $bin->name,
                'type' => $bin->type,
                'location' => $bin->location,

                'capacity' => $bin->capacity ?? 0,
                'battery' => $bin->battery ?? 100,

                'status' => $bin->computed_status,
                'color' => $bin->status_color,

                'sensor_error' => $bin->sensor_error,
                'online' => $bin->isOnline(),

                'last_seen_at' => optional($bin->last_seen_at)
                    ? $bin->last_seen_at->format('H:i:s')
                    : '-',
            ];
        });

        if ($filter != 'all') {
            $bins = $bins->filter(function ($bin) use ($filter) {
                return $bin['status'] == $filter;
            })->values();
        }

        $stats = [
            'total' => $allBins->count(),

            'full' => $allBins->filter(function ($bin) {
                return $bin->computed_status == 'Full';
            })->count(),

            'normal' => $allBins->filter(function ($bin) {
                return $bin->computed_status == 'Normal';
            })->count(),

            'maintenance' => $allBins->filter(function ($bin) {
                return $bin->computed_status == 'Maintenance';
            })->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $bins->values(),
            'stats' => $stats,
        ]);
    }

    public function getStats()
    {
        $bins = Bin::all();

        return response()->json([
            'success' => true,
            'data' => [

                'total_bins' => $bins->count(),

                'full_bins' => $bins->filter(function ($bin) {
                    return $bin->computed_status == 'Full';
                })->count(),

                'normal_bins' => $bins->filter(function ($bin) {
                    return $bin->computed_status == 'Normal';
                })->count(),

                'maintenance_bins' => $bins->filter(function ($bin) {
                    return $bin->computed_status == 'Maintenance';
                })->count(),

                'average_capacity' => round($bins->avg('capacity'), 1),

                'average_battery' => round($bins->avg('battery'), 1),

                'last_updated' => now()->format('H:i:s'),
            ]
        ]);
    }
}