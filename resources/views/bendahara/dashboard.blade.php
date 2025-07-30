@extends('bendahara.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700">Welcome, {{ auth()->user()->nama }}!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <a href="{{ route('bendahara.keuangan.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
            <div class="bg-white p-6 rounded-xl">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Dana</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">Rp {{ number_format($totalDana, 0, ',', '.') }}</p>
                            <p @class([
                                'text-4x2 flex items-center mt-6',
                                'text-green-600' => $trenPerbandingan == 'naik',
                                'text-red-600' => $trenPerbandingan == 'turun',
                            ])>
                                @if ($trenPerbandingan == 'naik')
                                    <i class="las la-arrow-up"></i>
                                @else
                                    <i class="las la-arrow-down"></i>
                                @endif
                                <span class="ml-1">{{ number_format(abs($persentasePerbandingan), 1) }}% From last month</span>
                            </p>
                        </div>
                        {{-- Bagian Ikon --}}
                        <div class="p-3 bg-green-100 rounded-full">
                            <i class="las la-wallet text-2xl text-green-500"></i>
                        </div>
                    </div>
            </div>
        </a>

        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Alokasi Dana</h3>
            <div class="h-28">
                <canvas id="ringkasanChart"></canvas>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white p-6 rounded-xl border border-gray-200 shadow-sm" x-data="keuanganChart()">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Data Keuangan</h2>
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
@endsection

@push('scripts')
<script>
    // Inisialisasi Donut Chart (dijalankan sekali saat halaman dimuat)
    document.addEventListener('DOMContentLoaded', function() {
        const pemasukan = {{ $pemasukan }};
        const pengeluaran = {{ $pengeluaran }};
        const ringkasanCtx = document.getElementById('ringkasanChart');
        if (ringkasanCtx) {
            new Chart(ringkasanCtx, {
                type: 'pie',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        data: [pemasukan, pengeluaran],
                        backgroundColor: ['rgb(34, 197, 94)', 'rgb(239, 68, 68)'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 12, font: { size: 12 } } }
                    },
                    cutout: '70%'
                }
            });
        }
    });

    // Komponen Alpine.js untuk Grafik Garis Keuangan
    function keuanganChart() {
        let chartInstance = null;
        return {
            selectedTahun: '{{ date('Y') }}',
            init() {
                setTimeout(() => {
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
                                y: { ticks: { callback: function(value) { return new Intl.NumberFormat('id-ID', { notation: 'compact' }).format(value); } } }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) { label += ': '; }
                                            if (context.parsed.y !== null) {
                                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    this.updateChart();
                    this.$watch('selectedTahun', () => this.updateChart());
                }, 0);
            },
            async updateChart() {
                if (!chartInstance) return;
                const response = await fetch(`{{ route('bendahara.charts.keuangan') }}?tahun=${this.selectedTahun}`);
                const result = await response.json();
                chartInstance.data.datasets[0].data = result.pemasukan;
                chartInstance.data.datasets[1].data = result.pengeluaran;
                chartInstance.update();
            }
        }
    }
</script>
@endpush