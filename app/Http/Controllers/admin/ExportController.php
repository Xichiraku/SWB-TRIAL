<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bin;
use App\Models\HistoryLog;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function reportPdf()
{

    $bins = Bin::all();

    $history = HistoryLog::latest()
                ->take(20)
                ->get();

    $totalSorting = HistoryLog::where('status','Success')->count();

    $fullEvents = HistoryLog::where('status','Full')->count();

    $maintenanceEvents = HistoryLog::where('status','Maintenance')->count();

    $data = [

        'bins' => $bins,

        'history' => $history,

        'totalSorting' => $totalSorting,

        'fullEvents' => $fullEvents,

        'maintenanceEvents' => $maintenanceEvents,

        'generatedAt' => now()

    ];

    $pdf = Pdf::loadView(

        'admin.pdf.report',

        $data

    );

    return $pdf->download('SmartWasteReport.pdf');

}
}