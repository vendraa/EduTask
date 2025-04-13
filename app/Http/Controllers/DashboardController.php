<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $jumlahDosen = User::where('role', 'dosen')->count();
        $jumlahMahasiswa = User::where('role', 'mahasiswa')->count();
        
        // Menghitung jumlah tugas
        $jumlahTugas = Assignment::count();

        return view('dashboard', compact('jumlahDosen', 'jumlahMahasiswa', 'jumlahTugas'));
    }
}
