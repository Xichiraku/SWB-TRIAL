<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bin;

class BinController extends Controller
{
    public function show(string $binId)
    {
        if (!session()->has('user')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $bin = Bin::where('bin_id', $binId)->with('homebase')->first();

        if (!$bin) {
            return redirect()->back()->with('error', 'Bin tidak ditemukan.');
        }

        $userRole = session('user')['role'];

        // View bin.detail sudah ada, tetap digunakan
        // Di dalam view, gunakan $userRole untuk bedakan tampilan admin vs operator
        return view('bin.detail', compact('bin', 'userRole'));
    }
}