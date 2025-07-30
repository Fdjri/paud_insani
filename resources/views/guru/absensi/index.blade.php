@extends('guru.layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Absensi</h1>
    
    {{-- Memanggil component Livewire --}}
    @livewire('guru.absensi.index')
@endsection