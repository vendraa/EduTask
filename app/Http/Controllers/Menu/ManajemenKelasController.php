<?php

namespace App\Http\Controllers\Menu;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManajemenKelasController extends Controller
{
    public function daftarDosen(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search', '');
    
        $lecturers = User::where('role', 'dosen')
            ->where(function($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
    
        return view('menu.kelas.daftar-dosen', [
            'lecturers' => $lecturers,
            'search' => $search
        ]);
    }

    public function daftarMahasiswa(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
    
        $students = User::where('role', 'mahasiswa')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
    
        return view('menu.kelas.daftar-mahasiswa', compact('students'));
    }    

    public function createUsers() {
        return view('menu.kelas.create');
    }

    public function storeUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:dosen,mahasiswa',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        $user = Auth::user();
    
        if ($user->role === 'mahasiswa') {
            return redirect()->route('daftarDosen.mahasiswa.index')->with('success', 'User baru berhasil ditambahkan.');
        } elseif ($user->role === 'dosen') {
            return redirect()->route('daftarDosen.dosen.index')->with('success', 'User baru berhasil ditambahkan.');
        }
    
        return redirect()->back()->with('success', 'User baru berhasil ditambahkan.');
    }
}
