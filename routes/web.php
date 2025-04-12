<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Menu\TugasController;
use App\Http\Controllers\Menu\PengumumanController;
use App\Http\Controllers\Menu\ManajemenKelasController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified', 'role:mahasiswa'])->group(function() {

    Route::get('mahasiswa/dashboard', [DashboardController::class, 'index'])->name('dashboard.mahasiswa');

    Route::get('mahasiswa/pengumuman', [PengumumanController::class, 'index'])->name('announcement.mahasiswa.index');

    Route::get('mahasiswa/daftar-tugas', [TugasController::class, 'index'])->name('tasks.mahasiswa.index');
    Route::get('dosen/tambah-tugas', [TugasController::class, 'create'])->name('tasks.mahasiswa.create');
    Route::get('dosen/tugas-terkumpul', [TugasController::class, 'submitted'])->name('tasks.mahasiswa.submitted');
    Route::get('mahasiswa/riwayat-tugas', [TugasController::class, 'history'])->name('tasks.mahasiswa.history');

    Route::get('mahasiswa/daftar-dosen', [ManajemenKelasController::class, 'daftarDosen'])->name('daftarDosen.mahasiswa.index');
    Route::get('mahasiswa/daftar-mahasiswa', [ManajemenKelasController::class, 'daftarMahasiswa'])->name('daftarMahasiswa.mahasiswa.index');
});

Route::middleware(['auth', 'verified', 'role:dosen'])->group(function() {

    Route::get('dosen/dashboard', [DashboardController::class, 'index'])->name('dashboard.dosen');

    Route::get('dosen/pengumuman', [PengumumanController::class, 'index'])->name('announcement.dosen.index');

    Route::get('dosen/daftar-tugas', [TugasController::class, 'index'])->name('tasks.dosen.index');
    Route::get('dosen/tambah-tugas', [TugasController::class, 'create'])->name('tasks.dosen.create');
    Route::get('dosen/tugas-terkumpul', [TugasController::class, 'submitted'])->name('tasks.dosen.submitted');
    Route::get('dosen/riwayat-tugas', [TugasController::class, 'history'])->name('tasks.dosen.history');

    Route::get('dosen/daftar-dosen', [ManajemenKelasController::class, 'daftarDosen'])->name('daftarDosen.dosen.index');
    Route::get('dosen/daftar-mahasiswa', [ManajemenKelasController::class, 'daftarMahasiswa'])->name('daftarMahasiswa.dosen.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
