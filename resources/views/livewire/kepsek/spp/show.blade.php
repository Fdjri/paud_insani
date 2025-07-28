<div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4 pb-4 border-b">
        <div>
            <a href="{{ route('kepsek.spp.index', ['tahun' => $tahun]) }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors mb-1">
                <i class="las la-arrow-left text-lg"></i>
                <span>Kembali</span>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">SPP {{ $namaBulan }} {{ $tahun }}</h2>
        </div>
        <button wire:click="save" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            Simpan Perubahan
        </button>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <div class="flex items-center gap-4 bg-gray-100 border border-gray-200 rounded-lg p-2">
            <div class="flex items-center gap-2 text-sm text-gray-600 px-2"><i class="las la-filter text-lg"></i><span class="font-medium">Filter By</span></div>
            <div class="border-l border-gray-300 h-6"></div>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 focus:outline-none"><span>Kelas</span><i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i></button>
                <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-40 bg-white rounded-md shadow-lg z-10" style="display: none;">
                    <a href="#" @click.prevent="$wire.set('filterKelas', ''); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Kelas</a>
                    @foreach ($listKelas as $kelas)
                        <a href="#" @click.prevent="$wire.set('filterKelas', '{{ $kelas->nama_kelas }}'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ $kelas->nama_kelas }}</a>
                    @endforeach
                </div>
            </div>
            <div class="border-l border-gray-300 h-6"></div>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 focus:outline-none"><span>Status Bayar</span><i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i></button>
                <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-40 bg-white rounded-md shadow-lg z-10" style="display: none;">
                    <a href="#" @click.prevent="$wire.set('filterStatus', ''); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Status</a>
                    <a href="#" @click.prevent="$wire.set('filterStatus', 'Lunas'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lunas</a>
                    <a href="#" @click.prevent="$wire.set('filterStatus', 'Belum Lunas'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Belum Lunas</a>
                    <a href="#" @click.prevent="$wire.set('filterStatus', 'Cicil'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cicil</a>
                </div>
            </div>
            <div class="border-l border-gray-300 h-6"></div>
            <button wire:click="resetFilters" class="flex items-center gap-2 text-sm text-red-500 hover:underline px-2"><i class="las la-undo-alt text-lg"></i>Reset Filter</button>
        </div>
        <div class="relative">
            <i class="las la-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama Siswa..." class="w-full md:w-64 pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Bayar</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($siswas as $siswa)
                    <tr wire:key="{{ $siswa->id }}">
                        <td class="px-6 py-4">{{ $siswa->nis }}</td>
                        <td class="px-6 py-4 font-medium">{{ $siswa->nama_lengkap }}</td>
                        <td class="px-6 py-4">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div x-data="{ open: false, status: $wire.entangle('statusPembayaran.{{ $siswa->id }}') }" class="relative">
                                <button x-ref="trigger" @click="open = !open" 
                                        :class="{
                                            'bg-green-100 text-green-700': status === 'Lunas',
                                            'bg-red-100 text-red-700': status === 'Belum Lunas',
                                            'bg-blue-100 text-blue-700': status === 'Cicil'
                                        }"
                                        class="w-full text-left text-sm font-semibold py-1.5 px-3 rounded-lg flex justify-between items-center ...">
                                    <span x-text="status"></span>
                                    <i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                                </button>
                                <template x-teleport="body">
                                    <div x-show="open" @click.away="open = false" x-anchor.bottom-start.offset.4="$refs.trigger" x-transition class="w-40 bg-white rounded-md shadow-lg z-50 border">
                                        <a href="#" @click.prevent="status = 'Lunas'; open = false" class="block px-4 py-2 text-sm ...">Lunas</a>
                                        <a href="#" @click.prevent="status = 'Belum Lunas'; open = false" class="block px-4 py-2 text-sm ...">Belum Lunas</a>
                                        <a href="#" @click.prevent="status = 'Cicil'; open = false" class="block px-4 py-2 text-sm ...">Cicil</a>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4">Tidak ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $siswas->links() }}
    </div>
</div>