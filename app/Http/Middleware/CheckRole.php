<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  ...$roles  // Menerima satu atau lebih role sebagai parameter
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pertama, pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect('login');
        }

        // Ambil data user yang sedang login
        $user = auth()->user();

        // Loop melalui setiap role yang diizinkan untuk route ini
        foreach ($roles as $role) {
            // Gunakan fungsi hasRole() yang sudah kita buat di model User
            if ($user->hasRole($role)) {
                // Jika user memiliki salah satu role yang diizinkan, lanjutkan request
                return $next($request);
            }
        }

        // Jika user tidak memiliki role yang diizinkan, tolak akses
        abort(403, 'ANDA TIDAK MEMILIKI AKSES UNTUK MEMBUKA HALAMAN INI.');
    }
}