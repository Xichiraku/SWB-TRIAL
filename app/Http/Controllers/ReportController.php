<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\HistoryLog;

class ReportController extends Controller
{
    public function index()
    {
        // ===========================
        // CARD ATAS
        // ===========================

        $totalSorting = HistoryLog::where('status', 'Success')->count();

        $fullEvents = HistoryLog::where('status', 'Full')->count();

        $maintenanceEvents = HistoryLog::where('status', 'Maintenance')->count();

        // ===========================
        // WET VS DRY
        // ===========================

        $wetCount = HistoryLog::where('message', 'Waste sorted into Wet Bin')->count();

        $dryCount = HistoryLog::where('message', 'Waste sorted into Dry Bin')->count();

        // ===========================
        // TABEL BIN
        // ===========================

        $bins = Bin::orderBy('name')->get();

        // ======================================
// SORTING PER HARI
// ======================================

$sortingChart = [];

foreach (['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $day) {
    $sortingChart[$day] = 0;
}

foreach (
    HistoryLog::where('status','Success')->get()
    as $history
){

    $day = $history->created_at->format('D');

    if(isset($sortingChart[$day])){
        $sortingChart[$day]++;
    }

}

        return view('admin.report', compact(

            'totalSorting',
            'fullEvents',
            'maintenanceEvents',

            'wetCount',
            'dryCount',

            'bins',
            'sortingChart'

        ));
    }
}