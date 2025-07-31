@extends('operator.layouts.app')

@section('content')
    <div x-data="profilePage()">
        <h1 class="text-2xl font-semibold text-gray-700">Profile</h1>

        <div class="mt-6">
            <div class="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
                <form action="{{ route('operator.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center space-y-2 mb-8">
                        <img :src="imageUrl" class="h-24 w-24 rounded-full object-cover" alt="Current profile photo">
                        <button type="button" @click="isModalOpen = true" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                            Edit Photo
                        </button>
                        {{-- Input file tersembunyi yang akan dikirim bersama form --}}
                        <input type="file" name="foto" id="foto" class="hidden" @change="handleFileSelect">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" 
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik', $user->nik) }}" 
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nomor_anggota" class="block text-sm font-medium text-gray-700">Nomor Anggota</label>
                            <input type="text" name="nomor_anggota" id="nomor_anggota" value="{{ old('nomor_anggota', $user->nomor_anggota) }}" 
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('nomor_anggota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="pendidikan" class="block text-sm font-medium text-gray-700">Pendidikan</label>
                            <input type="text" name="pendidikan" id="pendidikan" value="{{ old('pendidikan', $user->pendidikan) }}" 
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('pendidikan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" 
                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm ...">
                            @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="npwp" class="block text-sm font-medium text-gray-700">NPWP</label>
                            <input type="text" name="npwp" id="npwp" value="{{ old('npwp', $user->npwp) }}" 
                                   class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('npwp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Ubah Password</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" name="password" id="password" autocomplete="new-password"
                                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Kosongkan jika tidak diubah">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm ...">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center mt-8">
                        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="isModalOpen" 
            @keydown.escape.window="isModalOpen = false" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;">
            
            <div class="flex items-center justify-center min-h-screen p-4">
                
                <div x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0" 
                    x-transition:enter-end="opacity-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100" 
                    x-transition:leave-end="opacity-0" 
                    class="fixed inset-0 bg-opacity-50 backdrop-blur-sm transition-opacity">
                </div>
                
                <div @click.away="isModalOpen = false" 
                    x-transition:enter="ease-out duration-300" 
                    x-transition:enter-start="opacity-0 scale-95" 
                    x-transition:enter-end="opacity-100 scale-100" 
                    x-transition:leave="ease-in duration-200" 
                    x-transition:leave-start="opacity-100" 
                    x-transition:leave-end="opacity-0" 
                    class="relative bg-white rounded-lg shadow-xl transform transition-all sm:w-full sm:max-w-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Upload new photo</h3>
                        <button type="button" @click="isModalOpen = false" class="text-gray-400 hover:text-gray-500">&times;</button>
                    </div>
                    
                    <div @dragover.prevent @dragleave.prevent="isDragging = false" @dragenter.prevent="isDragging = true" @drop.prevent="handleFileDrop" 
                        :class="{'border-blue-500 bg-blue-50': isDragging}"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center transition-colors">
                        
                        <div x-show="!imageUrlForPreview" class="space-y-2">
                            <p class="text-gray-500">Drag & drop your file here</p>
                            <p class="text-gray-400 text-sm">or</p>
                            <button type="button" @click="$refs.fileInput.click()" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300">
                                Choose File
                            </button>
                        </div>
                        
                        <div x-show="imageUrlForPreview" class="text-center">
                            <img :src="imageUrlForPreview" class="h-32 w-32 rounded-full object-cover mx-auto mb-4">
                            <p class="text-sm text-gray-500">File ready to upload. Click outside to confirm.</p>
                        </div>
                        
                        <input type="file" x-ref="fileInput" class="hidden" @change="handleFileSelect">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function profilePage() {
        return {
            isModalOpen: false,
            isDragging: false,
            imageUrl: '{{ $user->foto ? asset('storage/' . $user->foto) : 'https://i.pravatar.cc/150?u='.$user->id }}',
            imageUrlForPreview: null,

            handleFileSelect(event) {
                this.processFile(event.target.files[0]);
            },
            handleFileDrop(event) {
                this.isDragging = false;
                this.processFile(event.dataTransfer.files[0]);
            },
            processFile(file) {
                if (file && file.type.startsWith('image/')) {
                    // Buat preview untuk di modal
                    this.imageUrlForPreview = URL.createObjectURL(file);
                    // Buat preview untuk di halaman utama dan tutup modal
                    this.imageUrl = URL.createObjectURL(file); 
                    this.isModalOpen = false;
                    // Salin file ke input di form utama
                    document.getElementById('foto').files = new DataTransfer().files; // Kosongkan dulu
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('foto').files = dataTransfer.files;
                }
            }
        }
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    @endif
</script>
@endpush