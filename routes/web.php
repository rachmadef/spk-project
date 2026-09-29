<?php

use App\Http\Controllers\LaporanController;
use App\Livewire\InputPenilaian;
use App\Livewire\KriteriaManager;
use App\Livewire\SawCalculator;
use App\Livewire\SiswaManager;
use App\Livewire\UserManager;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Master Data Routes
    Route::get('kriteria', KriteriaManager::class)->name('kriteria.index');
    Route::get('siswa', SiswaManager::class)->name('siswa.index');
    Route::get('users', UserManager::class)->name('user.index');

    // SPK Transactions & Calculations
    Route::get('penilaian', InputPenilaian::class)->name('penilaian.input');
    Route::get('saw', SawCalculator::class)->name('saw.index');

    // Reports PDF
    Route::get('laporan/pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.pdf');
});

require __DIR__.'/settings.php';
