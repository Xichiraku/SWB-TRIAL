<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DashboardOperController;
use App\Http\Controllers\BinController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Admin\ExportController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Rute Baru untuk Halaman Detail
    Route::get('/admin/bin/{code}', [DashboardController::class, 'detail'])->name('admin.bin.detail');

    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings/update', [SettingController::class, 'update'])->name('admin.settings.update');

    Route::get('/admin/history', [HistoryController::class, 'index'])->name('admin.history');
    Route::get('/admin/history/refresh', [HistoryController::class, 'refresh'])->name('admin.history.refresh');
});

Route::prefix('api/admin')->group(function () {
    Route::get('/bins', [DashboardController::class, 'getBins']);
    Route::get('/stats', [DashboardController::class, 'getStats']);
    Route::post('/bins/update', [DashboardController::class, 'updateBinStatus']);
});

Route::middleware(['role:operator'])->group(function () {
    Route::get('/operator/dashboard', [DashboardOperController::class, 'index'])->name('operator.dashboard');
    Route::get('/operator/vacuumbin', [DashboardOperController::class, 'vacuumbin'])->name('operator.vacuumbin');
    Route::put('/vacuum/{id}/empty', [DashboardOperController::class, 'emptyVacuum'])->name('vacuum.empty');
    Route::put('/peringatan/{id}/resolve', [DashboardOperController::class, 'resolvePeringatan'])->name('peringatan.resolve');
    Route::get('/bin/{id}', [BinController::class, 'show'])->name('bin.detail');
    Route::get('/operator/notifikasi', [DashboardOperController::class, 'notifikasi'])->name('operator.notifikasi');
    Route::get('/operator/taskupdate', [DashboardOperController::class, 'taskUpdate'])->name('operator.taskupdate');
    Route::post('/operator/taskupdate/{id}/start', [DashboardOperController::class, 'startTask'])->name('operator.taskupdate.start');
    Route::post('/operator/taskupdate/{id}/complete', [DashboardOperController::class, 'completeTask'])->name('operator.taskupdate.complete');
});

Route::prefix('admin/export')->name('admin.export.')->group(function () {
    Route::get('/vacuum', [ExportController::class, 'exportVacuum'])->name('vacuum');
    Route::get('/homebase', [ExportController::class, 'exportHomebase'])->name('homebase');
    Route::get('/peringatan', [ExportController::class, 'exportPeringatan'])->name('peringatan');
});