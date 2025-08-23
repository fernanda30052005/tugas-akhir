@extends('layouts.app')

@section('title', 'Detail Pembimbing')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-3">Detail Pembimbing</h4>

    <div class="card p-3">
        <p><strong>Nama:</strong> {{ $pembimbing->nama }}</p>
        <p><strong>NIP:</strong> {{ $pembimbing->nip }}</p>
        <p><strong>Jenis Kelamin:</strong> {{ $pembimbing->jenis_kelamin }}</p>
        <p><strong>Email:</strong> {{ $pembimbing->email }}</p>
    </div>

    <a href="{{ route('pembimbing.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
