<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kepala Sekolah - PAUD Insani</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    
                    <a href="#" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/data-siswa*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-users text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">Data Siswa</span>
                    </a>
                    
                    <a href="#" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/absensi*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-clipboard-list text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">Absensi</span>
                    </a>

                    <a href="#" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/spp*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="las la-credit-card text-xl w-5 h-5 shrink-0"></i>
                        <span class="ml-3 font-medium sidebar-text">SPP</span>
                    </a>

                    <a href="#" class="flex items-center justify-center lg:justify-start px-4 py-2.5 rounded-lg transition-colors duration-200 {{ request()->is('kepsek/keuangan*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
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
                                <span class="ml-3 font-medium sidebar-text">Logout</span>
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
                <div class="relative">
                    <button id="profile-button" class="flex items-center space-x-2">
                        <img src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="avatar" class="h-10 w-10 rounded-full">
                    </button>
                    <div id="profile-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20 hidden">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </header>
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const profileButton = document.getElementById('profile-button');
            const profileMenu = document.getElementById('profile-menu');

            const applySidebarState = (state, animate = true) => {
                const transitions = ['transition-all', 'duration-300', 'ease-in-out'];
                if (!animate) {
                    sidebar.classList.remove(...transitions);
                    mainContent.classList.remove(...transitions);
                }

                if (state === 'collapsed') {
                    sidebar.classList.replace('w-64', 'w-20');
                    mainContent.classList.replace('lg:ml-64', 'lg:ml-20');
                    sidebarTexts.forEach(text => text.classList.add('lg:hidden'));
                } else {
                    sidebar.classList.replace('w-20', 'w-64');
                    mainContent.classList.replace('lg:ml-20', 'lg:ml-64');
                    sidebarTexts.forEach(text => text.classList.remove('lg:hidden'));
                }

                if (!animate) {
                    void sidebar.offsetWidth;
                    sidebar.classList.add(...transitions);
                    mainContent.classList.add(...transitions);
                }
            };

            const toggleSidebar = () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.toggle('-translate-x-full');
                } else {
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

            profileButton.addEventListener('click', (event) => {
                event.stopPropagation();
                profileMenu.classList.toggle('hidden');
            });
            window.addEventListener('click', () => {
                if (!profileMenu.classList.contains('hidden')) {
                    profileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>