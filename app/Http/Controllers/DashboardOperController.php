<?php

namespace App\Http\Controllers;

use App\Models\Homebase;
use App\Models\Vacuum;
use App\Models\Peringatan;

class DashboardOperController extends Controller
{
    public function dashboard()
    {
        $total_homebase   = Homebase::count();
        $total_vacuum     = Vacuum::count();
        $total_peringatan = Peringatan::count();

        $homebases = Homebase::orderBy('created_at', 'desc')->get();

        return view('operator.dashboard', [
            'total_homebase'   => $total_homebase,
            'total_vacuum'     => $total_vacuum,
            'total_peringatan' => $total_peringatan,
            'homebases'        => $homebases,
        ]);
    }
}