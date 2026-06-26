<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/presentasi', function () {
    return view('presentation', [
        'geminiApiKey' => config('services.gemini.key')
    ]);
})->name('presentation');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/journals/{journal}/status', [DashboardController::class, 'updateStatus'])
    ->middleware(['auth'])
    ->name('journals.updateStatus');

use App\Http\Controllers\TransactionWebController;
use App\Http\Controllers\SettingsWebController;
use App\Http\Controllers\ReportWebController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User & Role Management Routes
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);

    // Audit Trail Route
    Route::get('/audit-logs', [App\Http\Controllers\AuditController::class, 'index'])->name('audit.index');

    // Asset Management Routes
    Route::resource('assets', App\Http\Controllers\AssetController::class);

    // Transaksi Kas Web Routes
    Route::get('/transactions', [TransactionWebController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/cash-in', [TransactionWebController::class, 'storeCashIn'])->name('transactions.cash-in');
    Route::post('/transactions/cash-out', [TransactionWebController::class, 'storeCashOut'])->name('transactions.cash-out');
    Route::post('/transactions/transfer', [TransactionWebController::class, 'storeTransfer'])->name('transactions.transfer');
    Route::post('/transactions/non-cash', [TransactionWebController::class, 'storeNonCash'])->name('transactions.non-cash');

    // Pengaturan Cabang Web Routes
    Route::get('/settings/branch', [SettingsWebController::class, 'edit'])->name('settings.branch.edit');
    Route::post('/settings/branch', [SettingsWebController::class, 'update'])->name('settings.branch.update');

    // Master COA Web Routes
    Route::get('/settings/coa', [SettingsWebController::class, 'coaIndex'])->name('settings.coa.index');
    Route::post('/settings/coa', [SettingsWebController::class, 'coaStore'])->name('settings.coa.store');
    Route::put('/settings/coa/{coa}', [SettingsWebController::class, 'coaUpdate'])->name('settings.coa.update');
    Route::delete('/settings/coa/{coa}', [SettingsWebController::class, 'coaDestroy'])->name('settings.coa.destroy');
    Route::post('/settings/coa/{coa}/toggle', [SettingsWebController::class, 'coaToggleActive'])->name('settings.coa.toggle');

    // Laporan Keuangan Web Routes
    Route::get('/reports', [ReportWebController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';
