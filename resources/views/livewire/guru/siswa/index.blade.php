<div>
    @if ($kelasWali)
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-end items-center mb-6">
                <div class="relative">
                    <i class="las la-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Siswa..." class="w-full md:w-64 pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th> {{-- Kolom Aksi Ditambahkan --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($siswas as $siswa)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4"><img class="h-10 w-10 rounded-full object-cover" src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://i.pravatar.cc/150?u=' . $siswa->id }}" alt="Avatar" /></td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ Str::limit($siswa->alamat_tempat_tinggal, 35) }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $siswa->jenis_kelamin }}</td>
                                <td class="px-6 py-4"> {{-- Tombol Aksi Ditambahkan --}}
                                    <button wire:click="showDetail({{ $siswa->id }})" class="text-gray-400 hover:text-blue-600" title="Lihat Detail">
                                        <i class="las la-eye text-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data siswa di kelas ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $siswas->links() }}
            </div>
        </div>
    @else
        <div class="bg-white p-16 text-center rounded-xl border border-gray-200 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-700">Anda tidak menjadi wali kelas.</h2>
            <p class="text-gray-500 mt-2">Data siswa hanya bisa dilihat oleh wali kelas.</p>
        </div>
    @endif
    <div x-data="{ show: @entangle('showDetailModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl p-8">
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                @if ($currentSiswa)
                    <h3 class="text-2xl font-semibold border-b pb-4">Detail {{ $currentSiswa->nama_lengkap }}</h3>
                    <div class="mt-6 flex flex-col items-center"><img class="h-32 w-32 rounded-lg object-cover" src="{{ $currentSiswa->foto ? asset('storage/' . $currentSiswa->foto) : 'https://i.pravatar.cc/150?u=' . $currentSiswa->id }}" alt="Foto"></div>
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4 text-sm">
                        @php
                            function detailItem($label, $value) {
                                echo '<div>';
                                echo '<label class="block text-xs font-medium text-gray-500">' . $label . '</label>';
                                echo '<div class="mt-1 p-2 w-full bg-gray-100 border border-gray-200 rounded-md">' . ($value ?: '-') . '</div>';
                                echo '</div>';
                            }
                        @endphp
                        {{-- Data Diri Siswa --}}
                        {!! detailItem('Nama Lengkap', $currentSiswa->nama_lengkap) !!}
                        {!! detailItem('Nama Panggilan', $currentSiswa->nama_panggilan) !!}
                        {!! detailItem('NIS', $currentSiswa->nis) !!}
                        {!! detailItem('Kelas', $currentSiswa->kelas->nama_kelas ?? null) !!}
                        {!! detailItem('Jenis Kelamin', $currentSiswa->jenis_kelamin) !!}
                        {!! detailItem('No. KK', $currentSiswa->no_kk) !!}
                        {!! detailItem('NIK', $currentSiswa->nik) !!}
                        {!! detailItem('Tanggal Lahir', \Carbon\Carbon::parse($currentSiswa->tanggal_lahir)->format('d-m-Y')) !!}
                        {!! detailItem('Agama', $currentSiswa->agama) !!}
                        {!! detailItem('Kewarganegaraan', $currentSiswa->kewarganegaraan) !!}
                        {!! detailItem('Anak Ke-', $currentSiswa->anak_ke) !!}
                        {!! detailItem('Jumlah Saudara Kandung', $currentSiswa->jumlah_saudara_kandung) !!}
                        {!! detailItem('Bahasa Sehari-hari', $currentSiswa->bahasa_sehari_hari) !!}
                        {!! detailItem('Berat Badan', $currentSiswa->berat_badan . ' Kg') !!}
                        {!! detailItem('Tinggi Badan', $currentSiswa->tinggi_badan . ' Cm') !!}
                        {!! detailItem('Golongan Darah', $currentSiswa->golongan_darah) !!}
                        <div class="md:col-span-2">{!! detailItem('Penyakit Yang Pernah Diderita', $currentSiswa->penyakit_yang_pernah_diderita) !!}</div>
                        <div class="md:col-span-2">{!! detailItem('Alamat Tempat Tinggal', $currentSiswa->alamat_tempat_tinggal) !!}</div>

                        {{-- Data Orang Tua --}}
                        <div class="lg:col-span-4 mt-4 border-t pt-4">
                            <h4 class="text-base font-semibold text-gray-700">Data Orang Tua & Wali</h4>
                        </div>
                        {!! detailItem('Nama Ayah', $currentSiswa->nama_ayah_kandung) !!}
                        {!! detailItem('Pendidikan Ayah', $currentSiswa->pendidikan_ayah) !!}
                        {!! detailItem('Pekerjaan Ayah', $currentSiswa->pekerjaan_ayah) !!}
                        {!! detailItem('Nama Ibu', $currentSiswa->nama_ibu_kandung) !!}
                        {!! detailItem('Pendidikan Ibu', $currentSiswa->pendidikan_ibu) !!}
                        {!! detailItem('Pekerjaan Ibu', $currentSiswa->pekerjaan_ibu) !!}
                        {!! detailItem('Nama Wali', $currentSiswa->nama_wali) !!}
                        {!! detailItem('Pendidikan Wali', $currentSiswa->pendidikan_wali) !!}
                        {!! detailItem('Pekerjaan Wali', $currentSiswa->pekerjaan_wali) !!}
                        {!! detailItem('Hubungan Wali', $currentSiswa->hubungan_wali) !!}

                        {{-- Status Akademik --}}
                        <div class="lg:col-span-4 mt-4 border-t pt-4">
                            <h4 class="text-base font-semibold text-gray-700">Status Akademik</h4>
                        </div>
                        {!! detailItem('Tipe Siswa', $currentSiswa->tipe_murid) !!}
                        {!! detailItem('Status', ucfirst($currentSiswa->status)) !!}
                        {!! detailItem('Tahun Masuk', $currentSiswa->tahun_masuk) !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>