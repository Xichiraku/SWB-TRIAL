<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
}