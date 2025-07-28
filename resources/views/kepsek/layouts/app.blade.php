<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kepala Sekolah - PAUD Insani</title>
    
    {{-- Memuat Library Font & JavaScript --}}
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/teleport@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/anchor@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Memuat Aset dari Vite & Livewire --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    
    <div class="relative min-h-screen lg:flex">
        <div id="sidebar" class="bg-white shadow-lg w-64 shrink-0 fixed inset-y-0 left-0 lg:relative lg:translate-x-0 transform -translate-x-full transition-all duration-300 ease-in-out z-30">
            <div class="flex flex-col h-full">
                <div class="h-20 flex items-center justify-center shrink-0">
                    <a href="{{ route('kepala-sekolah.dashboard') }}" class="text-2xl font-bold">
                        <span class="text-blue-600 sidebar-text">PAUD</span>
                        <span class="text-gray-800 sidebar-text">Insani</span>
                    </a>
                </div>

                <nav class="flex-1 px-4 py-2 space-y-1">
                    <a href="{{ route('kepala-sekolah.dashboard') }}" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/dashboard*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-home text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">Dashboard</span>
                    </a>
                    <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider sidebar-text">Pages</p>
                    <a href="{{ route('kepsek.siswa.index') }}" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/data-siswa*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-users text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">Data Siswa</span>
                    </a>
                    
                    <a href="{{ route('kepsek.absensi.index') }}" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/absensi*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-clipboard-list text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">Absensi</span>
                    </a>

                    <a href="{{ route('kepsek.spp.index') }}" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/spp*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-credit-card text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">SPP</span>
                    </a>

                    <a href="{{ route('kepsek.keuangan.index') }}" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/keuangan*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-chart-bar text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">Data Keuangan</span>
                    </a>

                    <a href="#" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/guru*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-user-tie text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">Data Guru & Tendik</span>
                    </a>
                    
                    <div class="pt-2 mt-2 border-t border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg text-gray-600 hover:bg-red-100 hover:text-red-600 transition-colors duration-200">
                                <i class="las la-sign-out-alt text-xl w-5 h-5 shrink-0"></i>
                                <span class="ml-3 font-medium sidebar-text">Log out</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>

        <div id="main-content" class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out">
            <header class="flex justify-between items-center p-4 bg-white border-b shadow-sm">
                <button id="sidebar-toggle" class="text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex-1"></div>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-3">
                        <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://i.pravatar.cc/150?u=' . auth()->id() }}" alt="avatar" class="h-10 w-10 rounded-full object-cover">
                        <div class="text-left hidden md:block">
                            <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->nama }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        <div class="p-1 border border-gray-300 rounded-full">
                           <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </div>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-20" style="display: none;">
                        <div class="py-2">
                            <a href="{{ route('kepsek.profile.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="las la-user-tie text-xl w-5 h-5 mr-3 text-blue-500"></i>
                                Profile
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                                    <i class="las la-sign-out-alt text-xl w-5 h-5 mr-3 text-red-500"></i>
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    @livewireScripts
    @stack('scripts')
    
    <script>
        // Listener ini berjalan saat struktur halaman HTML selesai dimuat.
        // Cocok untuk interaksi elemen dasar seperti sidebar.
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');

            const applySidebarState = (state, animate = true) => {
                const transitions = ['transition-all', 'duration-300', 'ease-in-out'];
                if (!animate) sidebar.classList.remove(...transitions);
                
                if (state === 'collapsed') {
                    sidebar.classList.replace('w-64', 'w-20');
                    sidebarTexts.forEach(text => text.classList.add('lg:hidden'));
                } else {
                    sidebar.classList.replace('w-20', 'w-64');
                    sidebarTexts.forEach(text => text.classList.remove('lg:hidden'));
                }

                if (!animate) {
                    void sidebar.offsetWidth; // Memaksa browser menggambar ulang sebelum menambahkan transisi
                    sidebar.classList.add(...transitions);
                }
            };

            const toggleSidebar = () => {
                if (window.innerWidth < 1024) { // Tampilan Mobile
                    sidebar.classList.toggle('-translate-x-full');
                } else { // Tampilan Desktop
                    const isCollapsed = sidebar.classList.contains('w-20');
                    const newState = isCollapsed ? 'open' : 'collapsed';
                    applySidebarState(newState);
                    localStorage.setItem('sidebarState', newState);
                }
            };
            
            sidebarToggle.addEventListener('click', toggleSidebar);

            if (window.innerWidth >= 1024) {
                const savedState = localStorage.getItem('sidebarState') || 'open';
                applySidebarState(savedState, false);
            }
        });

        // Listener ini berjalan saat Livewire selesai diinisialisasi.
        // Cocok untuk interaksi yang bergantung pada Livewire.
        document.addEventListener('livewire:init', () => {
            // Menampilkan notifikasi sukses dari backend
            Livewire.on('notify', (message) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });

            // ==========================================================
            // PERUBAHAN DI SINI: Menggunakan window.addEventListener
            // ==========================================================
            window.addEventListener('show-delete-confirmation', event => {
                Swal.fire({
                    title: 'Apakah anda ingin menghapus data?',
                    text: `Data siswa bernama "${event.detail.name}" tidak bisa dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, kirim event KE Livewire untuk menghapus
                        Livewire.dispatch('delete-confirmed', { id: event.detail.id });
                    }
                });
            });
        });
    </script>
</body>
</html>