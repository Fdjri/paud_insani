@extends('kepsek.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700">Welcome, {{ auth()->user()->nama }}!</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <a href="{{ route('kepsek.siswa.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalSiswa) }}</p>
                </div>
                <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 rounded-full">
                    <i class="las la-users text-3xl text-indigo-500"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('kepsek.guru.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Guru</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalGuru) }}</p>
                </div>
                <div class="w-12 h-12 flex items-center justify-center bg-yellow-100 rounded-full">
                    <i class="las la-user-tie text-3xl text-yellow-500"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('kepsek.guru.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Tendik</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalTendik) }}</p>
                </div>
                <div class="w-12 h-12 flex items-center justify-center bg-orange-100 rounded-full">
                    <i class="las la-user-friends text-3xl text-orange-500"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('kepsek.keuangan.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Dana</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalDana, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 flex items-center justify-center bg-green-100 rounded-full">
                    <i class="las la-wallet text-3xl text-green-500"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm" x-data="siswaChart()">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Jumlah Siswa per Tahun Masuk</h2>
                <div x-data="{ open: false }" class="relative w-32">
                    <button @click="open = !open" class="w-full text-sm bg-white border border-gray-300 text-gray-700 py-1.5 px-3 rounded-lg flex justify-between items-center">
                        <span x-text="selectedKelasLabel"></span>
                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'transform rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg z-10" style="display: none;">
                        <a href="#" @click.prevent="selectedKelas = 'semua'; selectedKelasLabel = 'Semua Kelas'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Kelas</a>
                        <a href="#" @click.prevent="selectedKelas = 'A'; selectedKelasLabel = 'Kelas A'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelas A</a>
                        <a href="#" @click.prevent="selectedKelas = 'B'; selectedKelasLabel = 'Kelas B'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelas B</a>
                    </div>
                </div>
            </div>
            <div class="h-80"><canvas x-ref="siswaCanvas"></canvas></div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm" x-data="keuanganChart()">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Data Keuangan per Bulan</h2>
                <div x-data="{ open: false }" class="relative w-32">
                    <button @click="open = !open" class="w-full text-sm bg-white border border-gray-300 text-gray-700 py-1.5 px-3 rounded-lg flex justify-between items-center">
                        <span x-text="selectedTahun"></span>
                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'transform rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg z-10" style="display: none;">
                        <a href="#" @click.prevent="selectedTahun = '{{ date('Y') }}'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ date('Y') }}</a>
                        <a href="#" @click.prevent="selectedTahun = '{{ date('Y') - 1 }}'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ date('Y') - 1 }}</a>
                        <a href="#" @click.prevent="selectedTahun = '{{ date('Y') - 2 }}'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ date('Y') - 2 }}</a>
                    </div>
                </div>
            </div>
            <div class="h-80"><canvas x-ref="keuanganCanvas"></canvas></div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Komponen Alpine.js untuk Grafik Siswa
    function siswaChart() {
        let chartInstance = null; // Pindahkan instance chart ke luar state reaktif

        return {
            selectedKelas: 'semua',
            selectedKelasLabel: 'Semua Kelas',
            init() {
                const ctx = this.$refs.siswaCanvas.getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Jumlah Siswa Masuk', data: [],
                            borderColor: 'rgb(79, 70, 229)', backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true, tension: 0.4
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
                });
                
                this.updateChart();
                this.$watch('selectedKelas', () => this.updateChart());
            },
            async updateChart() {
                if (!chartInstance) return;
                const response = await fetch(`{{ route('kepsek.charts.siswa') }}?kelas=${this.selectedKelas}`);
                const result = await response.json();
                chartInstance.data.labels = result.labels;
                chartInstance.data.datasets[0].data = result.data;
                chartInstance.update();
            }
        }
    }

    // Komponen Alpine.js untuk Grafik Keuangan
    function keuanganChart() {
        let chartInstance = null;

        return {
            selectedTahun: '{{ date('Y') }}',
            init() {
                const ctx = this.$refs.keuanganCanvas.getContext('2d');
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            { label: 'Pemasukan', data: [], borderColor: 'rgb(34, 197, 94)', tension: 0.4 },
                            { label: 'Pengeluaran', data: [], borderColor: 'rgb(239, 68, 68)', tension: 0.4 }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { ticks: { /* ... Opsi format Rupiah Anda ... */ } }
                        },
                        plugins: {
                            // ===================================
                            // TAMBAHKAN KONFIGURASI LEGENDA INI
                            // ===================================
                            legend: {
                                position: 'top', // Posisi legenda (top, bottom, left, right)
                                align: 'end',    // Perataan (start, center, end)
                                labels: {
                                    boxWidth: 12,
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            // ===================================
                            tooltip: { /* ... Opsi tooltip Anda ... */ }
                        }
                    }
                });

                this.updateChart();
                this.$watch('selectedTahun', () => this.updateChart());
            },
            async updateChart() {
                if (!chartInstance) return;
                const response = await fetch(`{{ route('kepsek.charts.keuangan') }}?tahun=${this.selectedTahun}`);
                const result = await response.json();
                chartInstance.data.datasets[0].data = result.pemasukan;
                chartInstance.data.datasets[1].data = result.pengeluaran;
                chartInstance.update();
            }
        }
    }
</script>
@endpush