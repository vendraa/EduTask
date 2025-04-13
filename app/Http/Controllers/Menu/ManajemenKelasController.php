<?php

namespace App\Http\Controllers\Menu;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManajemenKelasController extends Controller
{
    public function daftarDosen(Request $request)
    {
        $perPage = $request->input('perPage', 10);
    
        $lecturers = User::where('role', 'dosen')
            ->paginate($perPage);
    
        return view('menu.kelas.daftar-dosen', compact('lecturers'));
    }

    public function daftarMahasiswa(Request $request)
    {
        $perPage = $request->input('perPage', 10);
    
        $students = User::where('role', 'mahasiswa')
            ->paginate($perPage);
    
        return view('menu.kelas.daftar-mahasiswa', compact('students'));
    }

}
