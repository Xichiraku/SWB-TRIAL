<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vacuum;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportVacuum(Request $request)
    {
        $month = $request->integer('month') ?? now()->month;
        $year  = $request->integer('year')  ?? now()->year;

        $vacuums = Vacuum::with('homebase')
            ->whereMonth('updated_at', $month)
            ->whereYear('updated_at', $year)
            ->get();

        $monthName = Carbon::createFromDate($year, $month, 1)
            ->locale('id')
            ->monthName;

        $data = [
            'title'       => 'Laporan Data Vacuum',
            'month'       => $monthName,
            'year'        => $year,
            'vacuums'     => $vacuums,
            'generatedAt' => now()
                ->setTimezone('Asia/Jakarta')
                ->locale('id')
                ->isoFormat('dddd, D MMMM Y HH:mm')
        ];

        $pdf = Pdf::loadView('admin.exports.vacuumpdf', $data);
        return $pdf->download("vacuumpdf_{$year}_{$month}.pdf");
    }
}