<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses upaya login.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // 2. Coba lakukan autentikasi
        if (Auth::attempt($credentials)) {
            // Jika berhasil, regenerate session untuk keamanan
            $request->session()->regenerate();
            
            $user = Auth::user();

            // 3. Arahkan berdasarkan peran (role)
            switch ($user->role) {
                case 'kepala sekolah':
                    return redirect()->intended('/kepsek/dashboard');
                case 'bendahara':
                    return redirect()->intended('/bendahara/dashboard');
                case 'guru':
                    return redirect()->intended('/guru/dashboard');
                case 'operator':
                    return redirect()->intended('/operator/dashboard');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        // 4. Jika autentikasi gagal
        return back()->withErrors([
            'username' => 'Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Menangani proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}