@extends('bendahara.layouts.app')

@section('content')
    @livewire('bendahara.spp.show', ['tahun' => $tahun, 'bulan' => $bulan])
@endsection