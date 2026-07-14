<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (dari Breeze)
require __DIR__.'/auth.php';

// Routes yang butuh login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========== SURAT MASUK ==========
    Route::prefix('surat-masuk')->name('surat-masuk.')->group(function () {
        Route::get('/', [SuratMasukController::class, 'index'])->name('index');
        Route::get('/tambah', [SuratMasukController::class, 'create'])->name('create');
        Route::post('/simpan', [SuratMasukController::class, 'store'])->name('store');
        Route::get('/{id}', [SuratMasukController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SuratMasukController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SuratMasukController::class, 'update'])->name('update');
        Route::delete('/{id}/hapus', [SuratMasukController::class, 'destroy'])->name('destroy');
    });

    // ========== SURAT KELUAR ==========
    Route::prefix('surat-keluar')->name('surat-keluar.')->group(function () {
        Route::get('/', [SuratKeluarController::class, 'index'])->name('index');
        Route::get('/tambah', [SuratKeluarController::class, 'create'])->name('create');
        Route::post('/simpan', [SuratKeluarController::class, 'store'])->name('store');
        Route::get('/{id}', [SuratKeluarController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SuratKeluarController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SuratKeluarController::class, 'update'])->name('update');
        Route::delete('/{id}/hapus', [SuratKeluarController::class, 'destroy'])->name('destroy');

        // SUPERADMIN ONLY
        Route::get('/{id}/tinjau', [SuratKeluarController::class, 'tinjau'])
            ->name('tinjau')->middleware('role:superadmin');

        Route::post('/{id}/setujui', [SuratKeluarController::class, 'setujui'])
            ->name('setujui')->middleware('role:superadmin');

        Route::post('/{id}/tolak', [SuratKeluarController::class, 'tolak'])
            ->name('tolak')->middleware('role:superadmin');
    });

    // ========== MANAJEMEN PENGGUNA ==========
    Route::prefix('pengguna')->name('pengguna.')->middleware('role:superadmin')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('index');
        Route::get('/tambah', [PenggunaController::class, 'create'])->name('create');
        Route::post('/simpan', [PenggunaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PenggunaController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PenggunaController::class, 'update'])->name('update');
        Route::delete('/{id}/hapus', [PenggunaController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-aktif', [PenggunaController::class, 'toggleAktif'])->name('toggle-aktif');
    });

    // ========== LOG AKTIVITAS ==========
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])
        ->name('log-aktivitas.index')->middleware('role:superadmin');
    Route::get('/log-aktivitas/ekspor', [LogAktivitasController::class, 'ekspor'])
        ->name('log-aktivitas.ekspor')->middleware('role:superadmin');

    // ========== TRACKING ==========
    Route::get('/tracking', [SuratKeluarController::class, 'tracking'])->name('tracking');

    // ========== KATEGORI ==========
    Route::resource('kategori', KategoriController::class);

    // ========== PROFIL ==========
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});