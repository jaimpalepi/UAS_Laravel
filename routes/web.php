<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\FilmManager;
use App\Livewire\JadwalManager;
use App\Livewire\JadwalPublik;
use App\Livewire\PaymentPage;
use Illuminate\Support\Facades\Route;

// Halaman Publik (bisa diakses semua orang)
Route::get('/', JadwalPublik::class)->name('home');

Route::middleware('auth')->group(function () {
    // Dashboard (bisa diakses user & admin)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified', 'role:user,admin'])->name('dashboard');
    
    // Halaman Profil (bisa diakses user & admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Halaman Pembayaran (HANYA UNTUK USER)
    Route::get('/payment/{tiket}', PaymentPage::class)->middleware('role:user')->name('payment.page');

    // Halaman Manajemen (HANYA UNTUK ADMIN)
    Route::middleware('role:admin')->group(function() {
        Route::get('/manage-films', FilmManager::class)->name('manage.films');
        Route::get('/manage-jadwal', JadwalManager::class)->name('manage.jadwal');
    });
});

require __DIR__.'/auth.php';
