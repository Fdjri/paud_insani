<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('kepsek.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:16', Rule::unique('users')->ignore($user->id)],
            'nomor_anggota' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'pendidikan' => ['nullable', 'string', 'max:255'],
            'npwp' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
        ]);

        // Logika untuk menangani upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            // Simpan foto baru dan dapatkan path-nya
            $path = $request->file('foto')->store('avatars', 'public');
            $validated['foto'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}