@extends('guru.layouts.app')

@section('content')
    @livewire('guru.absensi.create', ['tanggal' => $tanggal])
@endsection