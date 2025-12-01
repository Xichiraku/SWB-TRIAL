<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DashboardOperController;
use App\Http\Controllers\BinController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HistoryController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard admin
Route::get('/admin/dashboard', function () {
    return view('admin.pages.dashboard');
})->name('admin.dashboard');

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

Route::get('/bin/{id}', [BinController::class, 'show'])->name('bin.detail');

// Settings Routes 
Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings');
Route::post('/admin/settings/update', [SettingController::class, 'update'])->name('admin.settings.update');

Route::get('/admin/history', [HistoryController::class, 'index'])->name('admin.history');
Route::get('/admin/history/refresh', [HistoryController::class, 'refresh'])->name('admin.history.refresh');

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