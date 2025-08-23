@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5>Tambah Siswa</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.siswa.store') }}" method="POST">
                @csrf
                @include('backend.siswa.partials.form')
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('backend.siswa.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
