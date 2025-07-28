@extends('kepsek.layouts.app')

@section('content')
    {{-- Header Halaman --}}
    <div class="relative flex items-center justify-center mb-6 pb-4 border-b">
        {{-- Judul di Kiri --}}
        <div class="absolute left-0">
            <h1 class="text-2xl font-semibold text-gray-700">SPP</h1>
        </div>

        {{-- Navigasi Tahun di Tengah --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('kepsek.spp.index', ['tahun' => $tahun - 1]) }}" class="p-2 rounded-full hover:bg-gray-100">
                <i class="las la-angle-left text-xl"></i>
            </a>
            <h2 class="text-lg font-semibold text-gray-800 w-24 text-center">{{ $tahun }}</h2>
            <a href="{{ route('kepsek.spp.index', ['tahun' => $tahun + 1]) }}" class="p-2 rounded-full hover:bg-gray-100">
                <i class="las la-angle-right text-xl"></i>
            </a>
        </div>
    </div>

    {{-- Daftar Bulan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach (range(1, 12) as $bulan)
            @php
                $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
            @endphp
            <a href="{{ route('kepsek.spp.show', ['tahun' => $tahun, 'bulan' => $bulan]) }}"
               class="block bg-white p-6 text-center rounded-xl border border-gray-200 shadow-sm hover:border-blue-500 hover:shadow-md transition-all">
                <p class="font-semibold text-gray-700">{{ $namaBulan }}</p>
            </a>
        @endforeach
    </div>
@endsection