<div>
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4 pb-4 border-b">
            <div>
                <a href="{{ route('kepsek.absensi.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-4">
                    <i class="las la-arrow-left text-lg"></i>
                    <span>Kembali ke Kalender</span>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">
                    Isi Absensi: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </h2>
            </div>
            @if (!$isHoliday)
                <button wire:click="save" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    Simpan Semua Perubahan
                </button>
            @endif
        </div>

        @if ($isHoliday)
            <div class="text-center py-16">
                <div class="inline-block bg-green-100 text-green-700 p-4 rounded-full">
                    <i class="las la-calendar-check text-5xl"></i>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-gray-800">Ini Adalah Hari Libur</h3>
                <p class="text-gray-500 mt-2">Tidak perlu mengisi absensi untuk tanggal ini. <br> Keterangan: <strong>{{ $holidayName }}</strong></p>
            </div>
        @else
            <div>
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
                                @foreach ($listKelas as $kelas)
                                    <a href="#" @click.prevent="$wire.set('filterKelas', '{{ $kelas->nama_kelas }}'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ $kelas->nama_kelas }}</a>
                                @endforeach
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
                                <a href="#" @click.prevent="$wire.set('filterStatus', 'Hadir'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hadir</a>
                                <a href="#" @click.prevent="$wire.set('filterStatus', 'Sakit'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sakit</a>
                                <a href="#" @click.prevent="$wire.set('filterStatus', 'Izin'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Izin</a>
                                <a href="#" @click.prevent="$wire.set('filterStatus', 'Alpa'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Alpa</a>
                            </div>
                        </div>
                        <div class="border-l border-gray-300 h-6"></div>
                        <button wire:click="resetFilters" class="flex items-center gap-2 text-sm text-red-500 hover:underline px-2">
                            <i class="las la-undo-alt text-lg"></i>
                            Reset Filter
                        </button>
                    </div>
                    <div class="relative">
                        <i class="las la-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Siswa..." class="w-full md:w-64 pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/4">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($siswas as $siswa)
                                <tr wire:key="{{ $siswa->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->nis }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $siswa->nama_lengkap }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div x-data="{ open: false, status: $wire.entangle('kehadiran.{{ $siswa->id }}') }" class="relative">
                                            <button x-ref="trigger" @click="open = !open" 
                                                    :class="{
                                                        'bg-green-100 text-green-700': status === 'Hadir',
                                                        'bg-purple-100 text-purple-700': status === 'Izin',
                                                        'bg-red-100 text-red-700': status === 'Alpa',
                                                        'bg-orange-100 text-orange-700': status === 'Sakit',
                                                        'bg-gray-100 text-gray-700': status === 'Kosong'
                                                    }"
                                                    class="w-full text-left text-sm font-semibold py-1.5 px-3 rounded-lg flex justify-between items-center transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <span x-text="status"></span>
                                                <i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                                            </button>
                                            <template x-teleport="body">
                                                <div x-show="open" @click.away="open = false" 
                                                     x-anchor.bottom-start.offset.4="$refs.trigger"
                                                     x-transition
                                                     class="w-40 bg-white rounded-md shadow-lg z-50 border"
                                                     style="display: none;">
                                                    <a href="#" @click.prevent="status = 'Hadir'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hadir</a>
                                                    <a href="#" @click.prevent="status = 'Sakit'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sakit</a>
                                                    <a href="#" @click.prevent="status = 'Izin'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Izin</a>
                                                    <a href="#" @click.prevent="status = 'Alpa'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Alpa</a>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada siswa yang cocok dengan filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6">
                    {{ $siswas->links() }}
                </div>
            </div>
        @endif
    </div>
</div>