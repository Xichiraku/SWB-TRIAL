<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardOperController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/operator/dashboard', [DashboardOperController::class, 'dashboard'])
    ->name('operator.dashboard');