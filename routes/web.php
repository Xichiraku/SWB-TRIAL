<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DashboardOperController;
use App\Http\Controllers\BinController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HistoryController;

// Route Login (tanpa middleware)
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Admin (hanya bisa diakses oleh admin)
Route::middleware(['role:admin'])->group(function () {
    // Dashboard admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Settings Routes 
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings/update', [SettingController::class, 'update'])->name('admin.settings.update');

    // History Routes
    Route::get('/admin/history', [HistoryController::class, 'index'])->name('admin.history');
    Route::get('/admin/history/refresh', [HistoryController::class, 'refresh'])->name('admin.history.refresh');
});

// API Routes untuk dashboard (di luar middleware atau bisa di dalam)
Route::prefix('api/admin')->group(function () {
    
    // Get all bins with filter
    Route::get('/bins', [DashboardController::class, 'getBins']);
    
    // Get dashboard statistics
    Route::get('/stats', [DashboardController::class, 'getStats']);
    
    // Update bin status (untuk sensor IoT nanti)
    Route::post('/bins/update', [DashboardController::class, 'updateBinStatus']);
    
});

// Route Operator (hanya bisa diakses oleh operator)
Route::middleware(['role:operator'])->group(function () {
    // Dashboard Operator
    Route::get('/operator/dashboard', [DashboardOperController::class, 'index'])
        ->name('operator.dashboard');

    // Vacuum Bin Routes
    Route::get('/operator/vacuumbin', [DashboardOperController::class, 'vacuumbin'])
        ->name('operator.vacuumbin');

    Route::put('/vacuum/{id}/empty', [DashboardOperController::class, 'emptyVacuum'])
        ->name('vacuum.empty');

    // Peringatan Routes
    Route::put('/peringatan/{id}/resolve', [DashboardOperController::class, 'resolvePeringatan'])
        ->name('peringatan.resolve');

    // Bin Detail Route
    Route::get('/bin/{id}', [BinController::class, 'show'])->name('bin.detail');

    // Notifikasi Routes
    Route::get('/operator/notifikasi', [DashboardOperController::class, 'notifikasi'])
        ->name('operator.notifikasi');

    // Task Update Routes
    Route::get('/operator/taskupdate', [DashboardOperController::class, 'taskUpdate'])
        ->name('operator.taskupdate');
    Route::post('/operator/taskupdate/{id}/start', [DashboardOperController::class, 'startTask'])
        ->name('operator.taskupdate.start');
    Route::post('/operator/taskupdate/{id}/complete', [DashboardOperController::class, 'completeTask'])
        ->name('operator.taskupdate.complete');
});