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

    Route::get('mahasiswa/daftar-tugas', [TugasController::class, 'index'])->name('assignments.mahasiswa.index');
    Route::get('mahasiswa/tugas/pengumpulan-tugas/{assignment}', [TugasController::class, 'submission'])->name('assignment.mahasiswa.submission');
    Route::post('mahasiswa/tugas/pengumpulan-tugas/{assignment}', [TugasController::class, 'storeSubmission'])->name('assignment.mahasiswa.submission.store');

    Route::get('mahasiswa/riwayat-tugas', [TugasController::class, 'history'])->name('assignments.mahasiswa.history');

    Route::get('mahasiswa/daftar-dosen', [ManajemenKelasController::class, 'daftarDosen'])->name('daftarDosen.mahasiswa.index');
    Route::get('mahasiswa/daftar-mahasiswa', [ManajemenKelasController::class, 'daftarMahasiswa'])->name('daftarMahasiswa.mahasiswa.index');

    Route::get('mahasiswa/profile/edit', [ProfileController::class, 'edit'])->name('profile.mahasiswa.edit');
});

Route::middleware(['auth', 'verified', 'role:dosen'])->group(function() {

    Route::get('dosen/dashboard', [DashboardController::class, 'index'])->name('dashboard.dosen');

    Route::get('dosen/pengumuman', [PengumumanController::class, 'index'])->name('announcement.dosen.index');

    Route::get('dosen/daftar-tugas', [TugasController::class, 'index'])->name('assignments.dosen.index');
    Route::get('dosen/tugas/tambah-tugas', [TugasController::class, 'create'])->name('assignments.dosen.create');
    Route::post('dosen/tugas', [TugasController::class, 'store'])->name('assignments.dosen.store');
    Route::get('dosen/tugas/edit-tugas/{assignment}', [TugasController::class, 'edit'])->name('assignments.dosen.edit');
    Route::put('dosen/tugas/update-tugas/{aasignment}', [TugasController::class, 'update'])->name('assignments.dosen.update');
    Route::get('dosen/tugas/{assignment}/detail', [TugasController::class, 'show'])->name('assignments.dosen.show');
    Route::get('dosen/tugas/{assignment}/tugas-terkumpul', [TugasController::class, 'submissions'])->name('assignments.dosen.submissions');
    Route::put('dosen/nilai/{submission}', [TugasController::class, 'beriNilai'])->name('assignments.dosen.beriNilai');
    Route::delete('dosen/tugas/{assignment}', [TugasController::class, 'destroy'])->name('assignments.dosen.destroy');
    Route::get('dosen/riwayat-tugas', [TugasController::class, 'history'])->name('assignments.dosen.history');

    Route::get('dosen/daftar-dosen', [ManajemenKelasController::class, 'daftarDosen'])->name('daftarDosen.dosen.index');
    Route::get('dosen/daftar-mahasiswa', [ManajemenKelasController::class, 'daftarMahasiswa'])->name('daftarMahasiswa.dosen.index');

    Route::get('dosen/profile/edit', [ProfileController::class, 'edit'])->name('profile.dosen.edit');
});

Route::get('/api/tugas', function (Illuminate\Http\Request $request) {
    $search = $request->input('search');
    $query = \App\Models\Assignment::with('lecturer')->orderByDesc('start_date');

    if ($search) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhereHas('lecturer', fn($q) => $q->where('name', 'like', "%{$search}%"));
    }

    return $query->limit(100)->get(); // Bisa ditambahkan pagination jika mau
});


require __DIR__.'/auth.php';
