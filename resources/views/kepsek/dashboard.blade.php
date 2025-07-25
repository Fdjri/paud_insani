@extends('kepsek.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700">Welcome, {{ auth()->user()->nama }}!</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                    <p class="text-4xl font-bold text-gray-800 mt-1">40,689</p>
                    <p class="text-xs text-green-600 flex items-center mt-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        8.5% Up from yesterday
                    </p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.071M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-4.67c.12-.318.232-.656.328-.998V10.5c0-.993.62-1.899 1.5-2.433a3.75 3.75 0 014.5 0c.88.534 1.5 1.44 1.5 2.433v.106c0 .342.108.68.328.998a6.375 6.375 0 0111.964 4.67l-.001.109A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Guru</p>
                    <p class="text-4xl font-bold text-gray-800 mt-1">1,293</p>
                    <p class="text-xs text-green-600 flex items-center mt-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        1.3% Up from past week
                    </p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Tendik</p>
                    <p class="text-4xl font-bold text-gray-800 mt-1">2,040</p>
                    <p class="text-xs text-green-600 flex items-center mt-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        1.8% Up from yesterday
                    </p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962a3.75 3.75 0 015.408 0M3 18.72a9.094 9.094 0 013.741-.479 3 3 0 01-4.682-2.72M12 12.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" /></svg>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Dana</p>
                    <p class="text-4xl font-bold text-gray-800 mt-1">Rp 89,000</p>
                    <p class="text-xs text-red-600 flex items-center mt-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        4.3% Down from yesterday
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-15c-.621 0-1.125-.504-1.125-1.125V8.25m15-3.75h-15m15 3.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Jumlah Siswa</h2>
                <div class="flex gap-2">
                    <select class="text-sm bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option>Aktif</option>
                    </select>
                    <select class="text-sm bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option>Kelas A</option>
                    </select>
                </div>
            </div>
            <div class="h-80">
                <canvas id="jumlahSiswaChart"></canvas>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Data Keuangan</h2>
                <select class="text-sm bg-gray-50 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option>2025</option>
                    <option>2024</option>
                </select>
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
        // --- GRAFIK JUMLAH SISWA (SAMA SEPERTI SEBELUMNYA) ---
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
        const configSiswa = { type: 'line', data: dataSiswa, options: { responsive: true, maintainAspectRatio: false } };
        new Chart(document.getElementById('jumlahSiswaChart'), configSiswa);


        // --- GRAFIK KEUANGAN (BARU) ---
        const labelsKeuangan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const dataKeuangan = {
            labels: labelsKeuangan,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: [1500000, 1800000, 1600000, 2000000, 2200000, 2500000, 2300000, 2700000, 3000000, 2800000, 3200000, 3500000],
                    borderColor: 'rgb(34, 197, 94)', // Hijau
                    tension: 0.4,
                },
                {
                    label: 'Pengeluaran',
                    data: [500000, 600000, 550000, 700000, 800000, 900000, 850000, 1000000, 1200000, 1100000, 1300000, 1500000],
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