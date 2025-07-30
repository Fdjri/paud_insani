<div x-data="{ isExportModalOpen: false, exportType: 'perbulan' }">
    <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-700">Data Keuangan</h1>
            <p class="text-sm text-gray-500 mt-1">Lacak semua pemasukan dan pengeluaran sekolah.</p>
        </div>
        <div class="bg-blue-600 text-white p-4 rounded-xl shadow-md text-center">
            <h3 class="text-sm font-medium uppercase tracking-wider">Total Dana</h3>
            <p class="text-2xl font-bold">Rp {{ number_format($totalDana, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4 bg-gray-100 border border-gray-200 rounded-lg p-2">
                <div class="flex items-center gap-2 text-sm text-gray-600 px-2">
                    <i class="las la-filter text-lg"></i>
                    <span class="font-medium">Filter By</span>
                </div>
                <div class="border-l border-gray-300 h-6"></div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 focus:outline-none">
                        <span>Bulan</span>
                        <i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-40 bg-white rounded-md shadow-lg z-10" style="display: none;">
                        <a href="#" @click.prevent="$wire.set('filterBulan', ''); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Bulan</a>
                        @foreach (range(1, 12) as $bulan)
                            <a href="#" @click.prevent="$wire.set('filterBulan', {{ $bulan }}); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="border-l border-gray-300 h-6"></div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 focus:outline-none">
                        <span>Tipe</span>
                        <i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-40 bg-white rounded-md shadow-lg z-10" style="display: none;">
                        <a href="#" @click.prevent="$wire.set('filterTipe', ''); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Tipe</a>
                        <a href="#" @click.prevent="$wire.set('filterTipe', 'pemasukan'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pemasukan</a>
                        <a href="#" @click.prevent="$wire.set('filterTipe', 'pengeluaran'); open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengeluaran</a>
                    </div>
                </div>

                <div class="border-l border-gray-300 h-6"></div>
                <button wire:click="resetFilters" class="flex items-center gap-2 text-sm text-red-500 hover:underline px-2">
                    <i class="las la-undo-alt text-lg"></i>
                    Reset Filter
                </button>
            </div>
            <div class="flex items-center gap-4">
                <button @click="isExportModalOpen = true" class="flex items-center gap-2 text-sm text-gray-600 hover:text-blue-600">
                    <i class="las la-print text-xl"></i> Print
                </button>
                <button wire:click="create" class="flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    <i class="las la-plus"></i> Tambah Data
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto border border-gray-200 rounded-lg mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 ...">No.</th>
                        <th class="px-6 py-3 ...">Description</th>
                        <th class="px-6 py-3 ...">Tipe</th>
                        <th class="px-6 py-3 ...">Tanggal</th>
                        <th class="px-6 py-3 ...">Quantity</th>
                        <th class="px-6 py-3 ...">Biaya</th>
                        <th class="px-6 py-3 ...">Total Biaya</th>
                        <th class="px-6 py-3 ...">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($keuangans as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium">{{ $item->deskripsi }}</td>
                            <td class="px-6 py-4">
                                <span @class(['px-2 inline-flex text-xs font-semibold rounded-full',
                                    'bg-green-100 text-green-800' => $item->tipe == 'pemasukan',
                                    'bg-red-100 text-red-800' => $item->tipe == 'pengeluaran',
                                ])>{{ ucfirst($item->tipe) }}</span>
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                            <td class="px-6 py-4">{{ $item->jumlah }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->jumlah * $item->biaya, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="inline-flex rounded-md border border-gray-300 shadow-sm">
                                    <button wire:click="edit({{ $item->id }})" title="Edit" class="p-2 ...">
                                        <i class="las la-edit text-lg"></i>
                                    </button>
                                    <button @click="$dispatch('show-delete-confirmation', { name: '{{ $item->deskripsi }}', id: {{ $item->id }} })" title="Hapus" class="p-2 ...">
                                        <i class="las la-trash text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-4">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $keuangans->links() }}</div>
    </div>

    <div x-data="{ show: @entangle('showCreateModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl p-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Tambah Data Keuangan</h3>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <form wire:submit="store" class="mt-4">
                    @php
                        $inputStyle = 'mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm';
                        $labelStyle = 'block text-sm font-medium text-gray-700';
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="deskripsi_create" class="{{ $labelStyle }}">Deskripsi</label>
                            <input type="text" wire:model="form.deskripsi" id="deskripsi_create" placeholder="Contoh: Pembelian ATK" class="{{ $inputStyle }}">
                            @error('form.deskripsi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="tanggal_create" class="{{ $labelStyle }}">Tanggal</label>
                            <input type="date" wire:model="form.tanggal" id="tanggal_create" class="{{ $inputStyle }}">
                            @error('form.tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
                            
                            {{-- Dropdown Kustom dengan Alpine.js --}}
                            <div x-data="{ open: false, selectedTipe: $wire.entangle('form.tipe') }" class="relative mt-1">
                                <button type="button" @click="open = !open" 
                                        class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
                                    <span class="block truncate capitalize" x-text="selectedTipe"></span>
                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                        <i class="las la-angle-down text-gray-400"></i>
                                    </span>
                                </button>

                                <div x-show="open" 
                                    @click.away="open = false"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10"
                                    style="display: none;">
                                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        <li @click="selectedTipe = 'pemasukan'; open = false" 
                                            class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-gray-100">
                                            <span class="block truncate capitalize">Pemasukan</span>
                                        </li>
                                        <li @click="selectedTipe = 'pengeluaran'; open = false" 
                                            class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-gray-100">
                                            <span class="block truncate capitalize">Pengeluaran</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @error('form.tipe') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="jumlah_create" class="{{ $labelStyle }}">Jumlah</label>
                            <input type="number" wire:model="form.jumlah" id="jumlah_create" placeholder="Jumlah yang Dibeli" class="{{ $inputStyle }}">
                            @error('form.jumlah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="biaya_create" class="{{ $labelStyle }}">Biaya Satuan</label>
                            <input type="number" wire:model="form.biaya" id="biaya_create" placeholder="Rp xxx.xxx" class="{{ $inputStyle }}">
                            @error('form.biaya') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="show = false" class="px-6 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 font-semibold text-sm border border-gray-300">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div x-data="{ show: @entangle('showEditModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl p-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Data Keuangan</h3>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <form wire:submit="update" class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <input type="text" wire:model="form.deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('form.deskripsi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" wire:model="form.tanggal" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('form.tanggal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe</label>
                            
                            {{-- Dropdown Kustom dengan Alpine.js --}}
                            <div x-data="{ open: false, selectedTipe: $wire.entangle('form.tipe') }" class="relative mt-1">
                                <button type="button" @click="open = !open" 
                                        class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
                                    <span class="block truncate capitalize" x-text="selectedTipe"></span>
                                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                        <i class="las la-angle-down text-gray-400"></i>
                                    </span>
                                </button>

                                <div x-show="open" 
                                    @click.away="open = false"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10"
                                    style="display: none;">
                                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        <li @click="selectedTipe = 'pemasukan'; open = false" 
                                            class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-gray-100">
                                            <span class="block truncate capitalize">Pemasukan</span>
                                        </li>
                                        <li @click="selectedTipe = 'pengeluaran'; open = false" 
                                            class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-gray-100">
                                            <span class="block truncate capitalize">Pengeluaran</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @error('form.tipe') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" wire:model="form.jumlah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('form.jumlah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Biaya Satuan</label>
                            <input type="number" wire:model="form.biaya" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('form.biaya') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="show = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg font-semibold text-sm">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold text-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="isExportModalOpen" @keydown.escape.window="isExportModalOpen = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="isExportModalOpen" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm transition-opacity"></div>
            
            <div @click.away="isExportModalOpen = false" x-show="isExportModalOpen" x-transition class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl p-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Apa Data Yang Ingin Anda Ekspor?</h3>
                    <button @click="isExportModalOpen = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>

                {{-- Form diubah untuk menargetkan route export --}}
                <form action="{{ route('bendahara.keuangan.export') }}" method="POST" class="mt-4">
                    @csrf
                    {{-- Dropdown Kustom dengan Animasi --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Perbulan/Pertahun</label>
                        <div x-data="{ open: false }" class="relative mt-1">
                            <button type="button" @click="open = !open" 
                                    class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm">
                                <span class="block truncate capitalize" x-text="exportType.replace('per', 'Per ')"></span>
                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                    <i class="las la-angle-down text-gray-400"></i>
                                </span>
                            </button>

                            <div x-show="open" 
                                @click.away="open = false"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10"
                                style="display: none;">
                                <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                    <li @click="exportType = 'perbulan'; open = false" 
                                        class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-gray-100">
                                        <span class="block truncate">Perbulan</span>
                                    </li>
                                    <li @click="exportType = 'pertahun'; open = false" 
                                        class="text-gray-900 relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-gray-100">
                                        <span class="block truncate">Pertahun</span>
                                    </li>
                                </ul>
                            </div>
                            {{-- Input tersembunyi untuk mengirim nilai exportType --}}
                            <input type="hidden" name="tipe_ekspor" :value="exportType">
                        </div>
                    </div>

                    {{-- Opsi Perbulan --}}
                    <div x-show="exportType === 'perbulan'">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pilih Bulan</label>
                                <select name="bulan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @foreach (range(1, 12) as $bulan)
                                        <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun</label>
                                <input type="number" name="tahun_bulan" value="{{ now()->year }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                    
                    {{-- Opsi Pertahun --}}
                    <div x-show="exportType === 'pertahun'">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilih Tahun</label>
                            <select name="tahun" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach (range(now()->year, now()->year - 3) as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="isExportModalOpen = false" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold text-sm">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm">Ekspor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>