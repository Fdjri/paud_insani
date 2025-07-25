@extends('kepsek.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700">Welcome, {{ auth()->user()->nama }}!</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <a href="#" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
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
        <a href="#" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
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
        <a href="#" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
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
        <a href="#" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
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
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Jumlah Siswa</h2>
                <div class="flex gap-2">
                    <div x-data="{ open: false, selectedStatus: 'Aktif' }" class="relative w-28">
                        <button @click="open = !open" class="w-full text-sm bg-white border border-gray-300 text-gray-700 py-1.5 px-3 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition flex justify-between items-center">
                            <span x-text="selectedStatus"></span>
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'transform rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg z-10">
                            <a href="#" @click.prevent="selectedStatus = 'Aktif'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Aktif</a>
                            <a href="#" @click.prevent="selectedStatus = 'Lulus'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lulus</a>
                        </div>
                    </div>
                    <div x-data="{ open: false, selectedKelas: 'Kelas A' }" class="relative w-28">
                        <button @click="open = !open" class="w-full text-sm bg-white border border-gray-300 text-gray-700 py-1.5 px-3 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition flex justify-between items-center">
                            <span x-text="selectedKelas"></span>
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'transform rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg z-10">
                            <a href="#" @click.prevent="selectedKelas = 'Kelas A'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelas A</a>
                            <a href="#" @click.prevent="selectedKelas = 'Kelas B'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelas B</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-80">
                <canvas id="jumlahSiswaChart"></canvas>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Data Keuangan</h2>
                <div x-data="{ open: false, selectedYear: '2025' }" class="relative w-28">
                    <button @click="open = !open" class="w-full text-sm bg-white border border-gray-300 text-gray-700 py-1.5 px-3 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition flex justify-between items-center">
                        <span x-text="selectedYear"></span>
                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'transform rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg z-10">
                        <a href="#" @click.prevent="selectedYear = '2025'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">2025</a>
                        <a href="#" @click.prevent="selectedYear = '2024'; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">2024</a>
                    </div>
                </div>
            </div>
            <div class="h-80">
                <canvas id="dataKeuanganChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labelsSiswa = ['2025', '2026', '2027', '2028', '2029', '2030', '2031'];
        const dataSiswa = {
            labels: labelsSiswa,
            datasets: [{
                label: 'Jumlah Siswa',
                data: [25, 45, 50, 92, 48, 55, 60],
                borderColor: 'rgb(79, 70, 229)',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                fill: true,
                tension: 0.4,
            }]
        };
        const configSiswa = {
            type: 'line',
            data: dataSiswa,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };
        new Chart(document.getElementById('jumlahSiswaChart'), configSiswa);

        const labelsKeuangan = @json($namaBulan);
        const dataKeuangan = {
            labels: labelsKeuangan,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: @json($dataPemasukan),
                    borderColor: 'rgb(34, 197, 94)', // Hijau
                    tension: 0.4,
                },
                {
                    label: 'Pengeluaran',
                    data: @json($dataPengeluaran),
                    borderColor: 'rgb(239, 68, 68)', // Merah
                    tension: 0.4,
                }
            ]
        };
        const configKeuangan = {
            type: 'line',
            data: dataKeuangan,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            // Format label sumbu Y menjadi format Rupiah
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            // Format tooltip menjadi format Rupiah
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        };
        new Chart(document.getElementById('dataKeuanganChart'), configKeuangan);
    });
</script>
@endpush