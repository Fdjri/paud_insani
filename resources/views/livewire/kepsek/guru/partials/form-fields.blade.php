<div class="overflow-y-auto max-h-[70vh] p-1">
    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="mt-6 flex flex-col items-center">
        @if ($foto)
            <img src="{{ $foto->temporaryUrl() }}" class="h-32 w-32 rounded-lg object-cover">
        @else
            <img src="{{ $currentUser?->foto ? asset('storage/' . $currentUser?->foto) : 'https://i.pravatar.cc/150?u=' . ($currentUser?->id ?? 'new') }}" class="h-32 w-32 rounded-lg object-cover">
        @endif
        <label for="foto-upload-guru" class="mt-2 text-sm text-blue-600 hover:underline cursor-pointer">Click to upload or drag and drop</label>
        <input id="foto-upload-guru" type="file" wire:model="foto" class="hidden">
        <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2"><div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div></div>
        @error('foto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 text-sm">
        @php
            $inputStyle = 'mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500';
            $labelStyle = 'block text-sm font-medium text-gray-700';
        @endphp
        
        <div><label class="{{ $labelStyle }}">Nama Lengkap</label><input type="text" wire:model="form.nama" class="{{ $inputStyle }}">@error('form.nama')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
        <div><label class="{{ $labelStyle }}">Tanggal Lahir</label><input type="date" wire:model="form.tanggal_lahir" class="{{ $inputStyle }}">@error('form.tanggal_lahir')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
        <div><label class="{{ $labelStyle }}">NIK</label><input type="text" wire:model="form.nik" class="{{ $inputStyle }}">@error('form.nik')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
        <div><label class="{{ $labelStyle }}">NPWP</label><input type="text" wire:model="form.npwp" class="{{ $inputStyle }}">@error('form.npwp')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
        <div><label class="{{ $labelStyle }}">Nomor Anggota</label><input type="text" wire:model="form.nomor_anggota" class="{{ $inputStyle }}">@error('form.nomor_anggota')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
        <div><label class="{{ $labelStyle }}">Periode</label><input type="text" wire:model="form.periode" placeholder="Contoh: 2024-2025" class="{{ $inputStyle }}">@error('form.periode')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
        <div><label class="{{ $labelStyle }}">Pendidikan</label><input type="text" wire:model="form.pendidikan" placeholder="Contoh: S1 PGPAUD" class="{{ $inputStyle }}"></div>
        <div><label class="{{ $labelStyle }}">Username</label><input type="text" wire:model="form.username" class="{{ $inputStyle }}">@error('form.username')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
        <div>
            <label class="{{ $labelStyle }}">Role</label>
            <select wire:model.live="form.role" class="{{ $inputStyle }}">
                <option value="guru">Guru</option>
                <option value="operator">Operator</option>
                <option value="bendahara">Bendahara</option>
                <option value="kepala sekolah">Kepala Sekolah</option>
            </select>
        </div>

        {{-- Kolom Kelas yang Muncul Secara Kondisional --}}
        @if ($form['role'] === 'guru')
            <div class="transition-all duration-300">
                <label class="{{ $labelStyle }}">Kelas Wali</label>
                <select wire:model="form.kelas_id" class="{{ $inputStyle }}">
                    <option value="">Tidak menjadi wali kelas</option>
                    @foreach ($listKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="md:col-span-3"><label class="{{ $labelStyle }}">Password</label><input type="password" wire:model="form.password" placeholder="{{ $showEditModal ? 'Kosongkan jika tidak diubah' : '' }}" class="{{ $inputStyle }}">@error('form.password')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
    </div>
</div>