<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryLog;
use App\Models\Bin;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->input('status');
        $binFilter    = $request->input('bin');
        $dateFilter   = $request->input('date');

        $query = HistoryLog::query();

        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if ($binFilter && $binFilter !== 'all') {
            $query->where('bin_id', $binFilter);
        }

        if ($dateFilter) {
            // MongoDB: filter by date string atau gunakan range pada created_at
            $query->whereDate('created_at', $dateFilter);
        }

        $records = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $stats = [

            'total' => HistoryLog::count(),

            'collections' => HistoryLog::where('status', 'Success')->count(),

            'maintenance' => HistoryLog::where('status', 'Maintenance')->count(),

            'alerts' => HistoryLog::where('status', 'Full')->count(),

        ];

        $bins = Bin::orderBy('bin_id')->get()->map(function ($bin) {
            return [
                'id' => $bin->bin_id,
                'name' => $bin->name ?? $bin->bin_id,
            ];
        });

        $dates = HistoryLog::distinct('created_at')
            ->orderBy('created_at', 'desc')
            ->pluck('created_at');

        return view('admin.history', compact('records', 'stats', 'bins', 'dates'));
    }

    public function refresh(Request $request)
    {
        return $this->index($request);
    }
}