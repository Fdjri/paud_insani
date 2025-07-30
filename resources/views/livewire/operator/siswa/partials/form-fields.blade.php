<div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" class="mt-6 flex flex-col items-center">
    @if ($foto)
        <img src="{{ $foto->temporaryUrl() }}" class="h-32 w-32 rounded-lg object-cover">
    @else
        <img src="{{ $currentSiswa?->foto ? asset('storage/' . $currentSiswa?->foto) : 'https://i.pravatar.cc/150?u=' . ($currentSiswa?->id ?? 'new') }}" class="h-32 w-32 rounded-lg object-cover">
    @endif
    <label for="foto-upload" class="mt-2 text-sm text-blue-600 hover:underline cursor-pointer">Click to upload or drag and drop</label>
    <input id="foto-upload" type="file" wire:model="foto" class="hidden">
    <div x-show="isUploading" class="w-full bg-gray-200 rounded-full h-2.5 mt-2"><div class="bg-blue-600 h-2.5 rounded-full" :style="`width: ${progress}%`"></div></div>
    @error('foto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
</div>

<div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4 text-sm">
    @php
        $inputStyle = 'mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500';
        $labelStyle = 'block text-sm font-medium text-gray-700';
    @endphp
    
    {{-- Data Diri Siswa --}}
    <div class="lg:col-span-4 mt-4 border-t pt-4"><h4 class="text-base font-semibold text-gray-700">Data Diri Siswa</h4></div>
    <div><label class="{{ $labelStyle }}">Nama Lengkap</label><input type="text" wire:model="form.nama_lengkap" class="{{ $inputStyle }}">@error('form.nama_lengkap')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
    <div><label class="{{ $labelStyle }}">Nama Panggilan</label><input type="text" wire:model="form.nama_panggilan" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">NIS</label><input type="text" wire:model="form.nis" class="{{ $inputStyle }}">@error('form.nis')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
    <div><label class="{{ $labelStyle }}">NIK</label><input type="text" wire:model="form.nik" class="{{ $inputStyle }}">@error('form.nik')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
    <div><label class="{{ $labelStyle }}">No. KK</label><input type="text" wire:model="form.no_kk" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Jenis Kelamin</label><select wire:model="form.jenis_kelamin" class="{{ $inputStyle }}"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select></div>
    <div><label class="{{ $labelStyle }}">Tanggal Lahir</label><input type="date" wire:model="form.tanggal_lahir" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Agama</label><input type="text" wire:model="form.agama" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Kewarganegaraan</label><input type="text" wire:model="form.kewarganegaraan" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Anak Ke-</label><input type="number" wire:model="form.anak_ke" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Jml. Saudara</label><input type="number" wire:model="form.jumlah_saudara_kandung" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Bahasa</label><input type="text" wire:model="form.bahasa_sehari_hari" class="{{ $inputStyle }}"></div>
    
    {{-- Data Fisik & Alamat --}}
    <div class="lg:col-span-4 mt-4 border-t pt-4"><h4 class="text-base font-semibold text-gray-700">Data Fisik & Alamat</h4></div>
    <div><label class="{{ $labelStyle }}">Berat Badan (Kg)</label><input type="text" wire:model="form.berat_badan" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Tinggi Badan (Cm)</label><input type="text" wire:model="form.tinggi_badan" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Golongan Darah</label><input type="text" wire:model="form.golongan_darah" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Jarak ke Sekolah</label><input type="text" wire:model="form.jarak_tempat_tinggal_ke_sekolah" class="{{ $inputStyle }}"></div>
    <div class="md:col-span-2"><label class="{{ $labelStyle }}">Riwayat Penyakit</label><input type="text" wire:model="form.penyakit_yang_pernah_diderita" class="{{ $inputStyle }}"></div>
    <div class="md:col-span-2"><label class="{{ $labelStyle }}">Alamat</label><textarea wire:model="form.alamat_tempat_tinggal" rows="2" class="{{ $inputStyle }}"></textarea></div>

    {{-- Data Orang Tua & Wali --}}
    <div class="lg:col-span-4 mt-4 border-t pt-4"><h4 class="text-base font-semibold text-gray-700">Data Orang Tua & Wali</h4></div>
    <div><label class="{{ $labelStyle }}">Nama Ayah</label><input type="text" wire:model="form.nama_ayah_kandung" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Pendidikan Ayah</label><input type="text" wire:model="form.pendidikan_ayah" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Pekerjaan Ayah</label><input type="text" wire:model="form.pekerjaan_ayah" class="{{ $inputStyle }}"></div>
    <div class="invisible"></div> {{-- Spacer --}}
    <div><label class="{{ $labelStyle }}">Nama Ibu</label><input type="text" wire:model="form.nama_ibu_kandung" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Pendidikan Ibu</label><input type="text" wire:model="form.pendidikan_ibu" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Pekerjaan Ibu</label><input type="text" wire:model="form.pekerjaan_ibu" class="{{ $inputStyle }}"></div>
    <div class="invisible"></div> {{-- Spacer --}}
    <div><label class="{{ $labelStyle }}">Nama Wali</label><input type="text" wire:model="form.nama_wali" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Pendidikan Wali</label><input type="text" wire:model="form.pendidikan_wali" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Pekerjaan Wali</label><input type="text" wire:model="form.pekerjaan_wali" class="{{ $inputStyle }}"></div>
    <div><label class="{{ $labelStyle }}">Hubungan Wali</label><input type="text" wire:model="form.hubungan_wali" class="{{ $inputStyle }}"></div>
    
    {{-- Status Akademik --}}
    <div class="lg:col-span-4 mt-4 border-t pt-4"><h4 class="text-base font-semibold text-gray-700">Status Akademik</h4></div>
    <div><label class="{{ $labelStyle }}">Tipe Siswa</label><select wire:model="form.tipe_murid" class="{{ $inputStyle }}"><option value="Siswa Baru">Siswa Baru</option><option value="Mutasi">Mutasi</option></select></div>
    <div><label class="{{ $labelStyle }}">Status</label><select wire:model="form.status" class="{{ $inputStyle }}"><option value="aktif">Aktif</option><option value="lulus">Lulus</option><option value="keluar">Keluar</option></select></div>
    <div><label class="{{ $labelStyle }}">Tahun Masuk</label><input type="number" wire:model="form.tahun_masuk" placeholder="Contoh: 2024" class="{{ $inputStyle }}">@error('form.tahun_masuk')<span class="text-red-500 text-xs">{{$message}}</span>@enderror</div>
    <div><label class="{{ $labelStyle }}">Kelas</label><select wire:model="form.kelas_id" class="{{ $inputStyle }}"><option value="">Otomatis Sesuai Usia</option>@foreach($listKelas as $kelas)<option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>@endforeach</select></div>
</div>