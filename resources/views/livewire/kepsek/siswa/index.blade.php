<div x-data>
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-4 bg-gray-100 border border-gray-200 rounded-lg p-2">
                <div class="flex items-center gap-2 text-sm text-gray-600 px-2">
                    <i class="las la-filter text-lg"></i>
                    <span class="font-medium">Filter By</span>
                </div>
                <div class="border-l border-gray-300 h-6"></div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 focus:outline-none">
                        <span>Kelas</span>
                        <i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-40 bg-white rounded-md shadow-lg z-10" style="display: none;">
                        <a href="#" @click.prevent="$wire.set('filterKelas', ''); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Kelas</a>
                        <a href="#" @click.prevent="$wire.set('filterKelas', 'A'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelas A</a>
                        <a href="#" @click.prevent="$wire.set('filterKelas', 'B'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelas B</a>
                    </div>
                </div>
                <div class="border-l border-gray-300 h-6"></div>
                <div x-data="{ open: false }" class="relative">
                     <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 focus:outline-none">
                        <span>Status</span>
                        <i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-40 bg-white rounded-md shadow-lg z-10" style="display: none;">
                        <a href="#" @click.prevent="$wire.set('filterStatus', ''); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Status</a>
                        <a href="#" @click.prevent="$wire.set('filterStatus', 'aktif'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Aktif</a>
                        <a href="#" @click.prevent="$wire.set('filterStatus', 'lulus'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lulus</a>
                        <a href="#" @click.prevent="$wire.set('filterStatus', 'keluar'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</a>
                    </div>
                </div>
                <div class="border-l border-gray-300 h-6"></div>
                <button wire:click="resetFilters" class="flex items-center gap-2 text-sm text-red-500 hover:underline px-2">
                    <i class="las la-undo-alt text-lg"></i>
                    Reset Filter
                </button>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <i class="las la-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Siswa..." class="w-full md:w-64 pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                </div>
                <button wire:click="create" class="flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    <i class="las la-plus"></i>
                    <span>Tambah Data</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Foto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($siswas as $siswa)
                        <tr class="hover:bg-gray-50" wire:key="{{ $siswa->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://i.pravatar.cc/150?u=' . $siswa->id }}" alt="Avatar" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($siswa->alamat_tempat_tinggal, 35) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span @class(['px-2 inline-flex text-xs leading-5 font-semibold rounded-full', 'bg-green-100 text-green-800' => $siswa->status == 'aktif', 'bg-purple-100 text-purple-800' => $siswa->status == 'lulus', 'bg-red-100 text-red-800' => $siswa->status == 'keluar'])>{{ ucfirst($siswa->status) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                {{-- Grup Tombol Aksi dengan Border --}}
                                <div class="inline-flex rounded-md border border-gray-300 shadow-sm">
                                    <button wire:click="showDetail({{ $siswa->id }})" title="Lihat Detail"
                                            class="p-2 inline-flex items-center text-gray-500 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-500 rounded-l-md">
                                        <i class="las la-eye text-lg"></i>
                                    </button>
                                    <button wire:click="edit({{ $siswa->id }})" title="Edit"
                                            class="p-2 inline-flex items-center border-l border-gray-300 text-gray-500 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-500">
                                        <i class="las la-edit text-lg"></i>
                                    </button>
                                    <button @click="$dispatch('show-delete-confirmation', { name: '{{ $siswa->nama_lengkap }}', id: {{ $siswa->id }} })" title="Hapus"
                                            class="p-2 inline-flex items-center border-l border-gray-300 text-gray-500 hover:bg-red-50 hover:text-red-600 focus:z-10 focus:ring-2 focus:ring-red-500 rounded-r-md">
                                        <i class="las la-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data yang ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $siswas->links() }}
        </div>
    </div>

    <div x-data="{ show: @entangle('showDetailModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
                <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl p-8">
                    <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                    @if ($currentSiswa)
                        <h3 class="text-2xl font-semibold border-b pb-4">Detail {{ $currentSiswa->nama_lengkap }}</h3>
                        <div class="mt-6 flex flex-col items-center"><img class="h-32 w-32 rounded-lg object-cover" src="{{ $currentSiswa->foto ? asset('storage/' . $currentSiswa->foto) : 'https://i.pravatar.cc/150?u=' . $currentSiswa->id }}" alt="Foto"></div>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-4 text-sm">
                        {{-- Fungsi untuk membuat satu item detail --}}
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

    <div x-data="{ show: @entangle('showEditModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl p-8">
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                <form wire:submit="update">
                    <h3 class="text-2xl font-semibold border-b pb-4">Edit {{ $currentSiswa?->nama_lengkap }}</h3>
                    <div class="overflow-y-auto max-h-[70vh] p-1">
                        {{-- Kode Form Lengkap (upload foto & semua input) --}}
                        @include('livewire.kepsek.siswa.partials.form-fields')
                    </div>
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="show = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold text-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-data="{ show: @entangle('showCreateModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-4xl p-8">
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                <form wire:submit="store">
                    <h3 class="text-2xl font-semibold border-b pb-4">Tambah Data Siswa</h3>
                    <div class="overflow-y-auto max-h-[70vh] p-1">
                        {{-- Kode Form Lengkap (upload foto & semua input) --}}
                        @include('livewire.kepsek.siswa.partials.form-fields')
                    </div>
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="show = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold text-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>