@extends('guru.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700">Welcome, {{ auth()->user()->nama }}!</h1>

    @if ($kelasWali)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <a href="{{ route('guru.siswa.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                <div class="md:col-span-1 bg-white p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-4x3 font-medium text-gray-500">Total Siswa (Kelas {{ $kelasWali->nama_kelas }})</p>
                            <p class="text-4xl font-bold text-gray-800 mt-5">{{ number_format($totalSiswa) }}</p>
                        </div>
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <i class="las la-users text-2xl text-indigo-500"></i>
                        </div>
                    </div>
                </div>
            </a>

            <div class="md:col-span-2 bg-white p-6 rounded-xl border border-gray-200 shadow-sm" x-data="rekapAbsensiChart()">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Rekap Absensi</h2>
                    
                    {{-- Filter Bulan dengan Animasi --}}
                    <div x-data="{ open: false }" class="relative w-40">
                        <button @click="open = !open" class="w-full text-sm bg-white border border-gray-300 text-gray-700 py-1.5 px-3 rounded-lg flex justify-between items-center">
                            <span x-text="new Date(2000, bulan - 1).toLocaleString('id-ID', { month: 'long' })"></span>
                            <i class="las la-angle-down transition-transform duration-200" :class="{'transform rotate-180': open}"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                            x-transition
                            class="absolute right-0 mt-2 w-full bg-white rounded-md shadow-lg z-10" 
                            style="display: none;">
                            @foreach (range(1, 12) as $month)
                                <a href="#" @click.prevent="bulan = {{ $month }}; open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="h-28">
                    <canvas x-ref="absensiCanvas"></canvas>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Siswa Kelas {{ $kelasWali->nama_kelas }}</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left ...">NIS</th>
                            <th class="px-6 py-3 text-left ...">Nama</th>
                            <th class="px-6 py-3 text-left ...">Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($siswas as $siswa)
                            <tr>
                                <td class="px-6 py-4">{{ $siswa->nis }}</td>
                                <td class="px-6 py-4 font-medium">{{ $siswa->nama_lengkap }}</td>
                                <td class="px-6 py-4">{{ $siswa->jenis_kelamin }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="mt-6 bg-white p-16 text-center rounded-xl border border-gray-200 shadow-sm">
            <h2 class="text-xl font-semibold text-gray-700">Anda tidak menjadi wali kelas.</h2>
            <p class="text-gray-500 mt-2">Hubungi operator untuk ditetapkan sebagai wali kelas.</p>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    function rekapAbsensiChart() {
        let chartInstance = null; // Pindahkan instance chart ke luar state reaktif Alpine

        return {
            bulan: {{ now()->month }},
            init() {
                setTimeout(() => {
                    const ctx = this.$refs.absensiCanvas.getContext('2d');
                    // Gunakan variabel non-reaktif 'chartInstance'
                    chartInstance = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
                            datasets: [{
                                data: [0, 0, 0, 0],
                                backgroundColor: ['#10B981', '#8B5CF6', '#F59E0B', '#EF4444'],
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
                    this.updateChart();
                    this.$watch('bulan', () => this.updateChart());
                }, 0);
            },
            async updateChart() {
                if (!chartInstance) return; // Periksa variabel non-reaktif
                
                const response = await fetch(`{{ route('guru.charts.absensi') }}?bulan=${this.bulan}&tahun={{ now()->year }}`);
                const result = await response.json();

                // Update data pada variabel non-reaktif
                chartInstance.data.datasets[0].data = [result.hadir, result.izin, result.sakit, result.alpa];
                chartInstance.update();
            }
        }
    }
</script>
@endpush