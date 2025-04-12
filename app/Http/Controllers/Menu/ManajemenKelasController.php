<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManajemenKelasController extends Controller
{
    public function daftarDosen() {
        return view('menu.kelas.daftar-dosen');
    }

    public function daftarMahasiswa() {
        return view('menu.kelas.daftar-mahasiswa');
    }
}
