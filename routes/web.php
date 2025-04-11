<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->group(function() {

    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'index'])->name('dashboard.mahasiswa');
});

Route::middleware(['auth', 'verified', 'role:dosen'])->group(function() {

    Route::get('/dashboard/dosen', [DashboardController::class, 'index'])->name('dashboard.dosen');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
