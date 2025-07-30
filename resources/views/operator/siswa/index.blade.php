@extends('operator.layouts.app')

@section('content')
    <div>
        <h1 class="text-2xl font-semibold text-gray-700 mb-6">Data Siswa</h1>
        
        {{-- Memanggil component Livewire --}}
        @livewire('operator.siswa.index')
    </div>
@endsection