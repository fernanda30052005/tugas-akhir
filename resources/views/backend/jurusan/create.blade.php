@extends('layouts.app')

@section('title', 'Tambah Jurusan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5>Tambah Jurusan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.jurusan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Nama Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" class="form-control"
                           value="{{ old('jurusan') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('backend.jurusan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
