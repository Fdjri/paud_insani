@extends('operator.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700">Welcome, {{ auth()->user()->nama }}!</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <a href="{{ route('operator.siswa.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
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
        <a href="{{ route('operator.guru.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
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
        <a href="{{ route('operator.guru.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
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
    </div>

    <div class="grid grid-cols-1 gap-6 mt-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm" x-data="siswaChart()">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Jumlah Siswa per Tahun Masuk</h2>
                {{-- Filter kelas telah dihapus --}}
            </div>
            <div class="h-80"><canvas x-ref="siswaCanvas"></canvas></div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function siswaChart() {
        let chartInstance = null;

        return {
            init() {
                setTimeout(() => {
                    // PERBAIKAN DI SINI: dari 'd' menjadi '2d'
                    const ctx = this.$refs.siswaCanvas.getContext('2d'); 
                    chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: [],
                            datasets: [{
                                label: 'Jumlah Siswa Masuk',
                                data: [],
                                borderColor: 'rgb(79, 70, 229)',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true } }
                        }
                    });
                    this.updateChart();
                }, 0);
            },
            async updateChart() {
                if (!chartInstance) return;
                
                const response = await fetch(`{{ route('operator.charts.siswa') }}`);
                const result = await response.json();
                
                chartInstance.data.labels = result.labels;
                chartInstance.data.datasets[0].data = result.data;
                chartInstance.update();
            }
        }
    }
</script>
@endpush