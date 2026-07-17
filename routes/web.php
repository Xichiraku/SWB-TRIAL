<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DashboardOperController;
use App\Http\Controllers\BinController;
use App\Http\Controllers\Api\BinSensorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\ReportController;
use App\Support\WhatsAppService;

// -------------------------------------------------------
// API SENSOR — dari ESP32, tidak butuh auth session
// -------------------------------------------------------
Route::post('/api/bins/update-sensor', [BinSensorController::class, 'updateFromSensor']);
Route::get('/api/bins/test', [BinSensorController::class, 'test']);

// -------------------------------------------------------
// WHATSAPP MANAGEMENT (admin only)
// -------------------------------------------------------
Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/whatsapp/status', function () {
        return app(WhatsAppService::class)->status();
    });

    Route::get('/whatsapp/groups', function () {
        return app(WhatsAppService::class)->groups();
    });

    Route::get('/whatsapp/pair/{number}', function ($number) {
        return app(WhatsAppService::class)->pair($number);
    });

    Route::post('/whatsapp/send', function (\Illuminate\Http\Request $request) {
        $request->validate(['to' => 'required|string', 'text' => 'required|string']);
        return app(WhatsAppService::class)->send($request->to, $request->text);
    });
});

// -------------------------------------------------------
// AUTHENTICATION
// -------------------------------------------------------
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// -------------------------------------------------------
// ADMIN
// -------------------------------------------------------
Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/bin/{code}', [DashboardController::class, 'detail'])->name('bin.detail');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

        Route::get('/history', [HistoryController::class, 'index'])->name('history');
        Route::get('/history/refresh', [HistoryController::class, 'refresh'])->name('history.refresh');

        Route::get('/report', [ReportController::class, 'index'])->name('report');

        // Export
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/bins', [ExportController::class, 'exportBins'])->name('bins');
            Route::get('/homebase', [ExportController::class, 'exportHomebase'])->name('homebase');
            Route::get('/peringatan', [ExportController::class, 'exportPeringatan'])->name('peringatan');
            Route::get('/report/pdf', [ExportController::class, 'reportPdf'])
            ->name('report.pdf');
        });
    });

// Admin API — AJAX dari halaman admin
Route::prefix('api/admin')->group(function () {
    Route::get('/bins', [DashboardController::class, 'getBins']);
    Route::get('/stats', [DashboardController::class, 'getStats']);
    Route::get('/bin/{code}/status', [DashboardController::class, 'getBinStatus'])->name('admin.bin.status');
    Route::post('/bins/update', [DashboardController::class, 'updateBinStatus']);
});

// -------------------------------------------------------
// OPERATOR
// -------------------------------------------------------
Route::middleware(['auth.check', 'role:operator'])
    ->prefix('operator')
    ->name('operator.')
    ->group(function () {

        Route::get('/dashboard', [DashboardOperController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/refresh', [DashboardOperController::class, 'refreshBins'])->name('dashboard.refresh');

        // Ganti dari /vacuumbin ke /bins
        Route::get('/bins', [DashboardOperController::class, 'bins'])->name('bins');

        Route::get('/notifikasi', [DashboardOperController::class, 'notifikasi'])->name('notifikasi');

        // Task update
        Route::get('/taskupdate', [DashboardOperController::class, 'taskUpdate'])->name('taskupdate');
        Route::post('/taskupdate/{id}/start', [DashboardOperController::class, 'startTask'])->name('operator.taskupdate.start');
        Route::post('/taskupdate/{id}/complete', [DashboardOperController::class, 'completeTask'])->name('operator.taskupdate.complete');

        // Detail bin — view sama dengan admin tapi $userRole = 'operator'
        // sehingga hardware detail dan analytics tidak ditampilkan
        Route::get('/bin/{id}', [BinController::class, 'show'])->name('bin.detail');
    });