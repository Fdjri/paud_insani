<div x-data>
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Data Guru & Tendik</h1>
        <div class="flex items-center gap-4">
            <div class="relative">
                <i class="las la-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari Nama..." class="w-full md:w-64 pl-9 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>
            <button wire:click="create" class="flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                <i class="las la-plus"></i>
                <span>Tambah Data</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($users as $user)
            <div wire:key="{{ $user->id }}" class="bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                <a href="#" wire:click.prevent="showDetail({{ $user->id }})">
                    <img class="h-56 w-full object-cover object-center" src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://i.pravatar.cc/400?u=' . $user->id }}" alt="Foto {{ $user->nama }}">
                </a>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-lg text-gray-800">{{ $user->nama }}</h3>
                    <p class="text-sm text-gray-500 capitalize">{{ $user->role }}</p>
                    <div class="mt-4 flex justify-center space-x-2 border-t pt-3">
                        <button wire:click="edit({{ $user->id }})" class="p-2 text-gray-400 hover:text-blue-600 transition-colors" title="Edit">
                            <i class="las la-edit text-xl"></i>
                        </button>
                        <button @click="$dispatch('show-delete-confirmation', { name: '{{ $user->nama }}', id: {{ $user->id }} })" class="p-2 text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                            <i class="las la-trash text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-16">Tidak ada data untuk ditampilkan.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>

    <div x-data="{ show: @entangle('showDetailModal') }" 
        x-show="show" 
        @keydown.escape.window="show = false" 
        class="fixed inset-0 z-50 overflow-y-auto" 
        style="display: none;">
        
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl p-8">
                <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                
                @if ($currentUser)
                    <h3 class="text-xl font-semibold border-b pb-4">Detail {{ $currentUser->nama }}</h3>

                    <div class="mt-6 flex flex-col items-center">
                        <img class="h-32 w-32 rounded-lg object-cover" 
                            src="{{ $currentUser->foto ? asset('storage/' . $currentUser->foto) : 'https://i.pravatar.cc/150?u=' . $currentUser->id }}" 
                            alt="Foto">
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                        @php
                            function detailUserItem($label, $value) {
                                echo '<div>';
                                echo '<label class="block text-xs font-medium text-gray-500">' . $label . '</label>';
                                echo '<div class="mt-1 p-2 w-full bg-gray-100 border border-gray-200 rounded-md">' . ($value ?: '-') . '</div>';
                                echo '</div>';
                            }
                        @endphp

                        {!! detailUserItem('Nama Lengkap', $currentUser->nama) !!}
                        {!! detailUserItem('Tanggal Lahir', \Carbon\Carbon::parse($currentUser->tanggal_lahir)->format('d-m-Y')) !!}
                        {!! detailUserItem('NIK', $currentUser->nik) !!}
                        {!! detailUserItem('NPWP', $currentUser->npwp) !!}
                        {!! detailUserItem('Nomor Anggota', $currentUser->nomor_anggota) !!}
                        {!! detailUserItem('Periode', $currentUser->periode) !!}
                        {!! detailUserItem('Pendidikan', $currentUser->pendidikan) !!}
                        {!! detailUserItem('Role', ucfirst($currentUser->role)) !!}

                        {{-- Tampilkan kolom ini hanya jika role adalah guru --}}
                        @if ($currentUser->role === 'guru')
                            {!! detailUserItem('Wali Kelas', $currentUser->kelas?->nama_kelas ?? '-') !!}
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div x-data="{ show: @entangle('showEditModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl p-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Ubah Data {{ $currentUser?->nama }}</h3>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <form wire:submit="update" class="mt-4">
                    @include('livewire.kepsek.guru.partials.form-fields')
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="show = false" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold text-sm">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div x-data="{ show: @entangle('showCreateModal') }" x-show="show" @keydown.escape.window="show = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="show" x-transition class="fixed inset-0 bg-opacity-50 backdrop-blur-sm"></div>
            <div x-show="show" x-transition @click.away="show = false" class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl p-6">
                <div class="flex justify-between items-center pb-3 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Tambah Data Guru/Tendik</h3>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <form wire:submit="store" class="mt-4">
                    @include('livewire.kepsek.guru.partials.form-fields')
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="show = false" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold text-sm">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>