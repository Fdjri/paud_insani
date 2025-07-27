@extends('kepsek.layouts.app')

@section('content')
    @livewire('kepsek.absensi.create', ['tanggal' => $tanggal])
@endsection