<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $statusFilter = $request->input('status');
        $binFilter = $request->input('bin');
        $dateFilter = $request->input('date');
        
        // Build query
        $query = DB::table('history_logs');
        
        // Apply filters
        if ($statusFilter && $statusFilter != 'all') {
            $query->where('status', $statusFilter);
        }
        
        if ($binFilter && $binFilter != 'all') {
            $query->where('bin', $binFilter);
        }
        
        if ($dateFilter) {
            $query->whereDate('date', $dateFilter);
        }
        
        // Get filtered records
        $records = $query->orderBy('date', 'desc')
                        ->orderBy('time', 'desc')
                        ->get();
        
        // Get statistics
        $stats = [
            'total' => DB::table('history_logs')->count(),
            'collections' => DB::table('history_logs')->where('status', 'Empetied')->count(),
            'maintenance' => DB::table('history_logs')->where('status', 'Battery Low')->count(),
            'alerts' => DB::table('history_logs')->where('status', 'Alert')->count()
        ];
        
        // Get unique bins
        $bins = DB::table('history_logs')
                  ->select('bin')
                  ->distinct()
                  ->orderBy('bin')
                  ->pluck('bin');
        
        // Get unique dates
        $dates = DB::table('history_logs')
                   ->select('date')
                   ->distinct()
                   ->orderBy('date', 'desc')
                   ->pluck('date');
        
        return view('admin.history', compact('records', 'stats', 'bins', 'dates'));
    }
    
    public function refresh(Request $request)
    {
        // Simulate real-time refresh
        return $this->index($request);
    }
}