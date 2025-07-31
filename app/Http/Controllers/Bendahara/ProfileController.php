<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil.
     */
    public function index()
    {
        $user = auth()->user();
        return view('bendahara.profile.index', compact('user'));
    }

    /**
     * Memperbarui data profil.
     */
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
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Hapus password dari array jika tidak diisi
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            // Hash password baru jika diisi
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $validated['foto'] = $request->file('foto')->store('user-photos', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}