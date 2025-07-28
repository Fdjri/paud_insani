@extends('kepsek.layouts.app')

@section('content')
    @livewire('kepsek.spp.show', ['tahun' => $tahun, 'bulan' => $bulan])
@endsection