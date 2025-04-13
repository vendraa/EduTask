<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create user baru jika belum ada
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(uniqid()), // generate password random
                    'email_verified_at' => now(),
                    'role' => 'mahasiswa', // atau 'dosen' sesuai kebutuhanmu
                ]);
            }

            Auth::login($user);

            return redirect()->intended('mahasiswa/dashboard'); // sesuaikan redirect
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Login dengan Google gagal!',
            ]);
        }
    }
}

