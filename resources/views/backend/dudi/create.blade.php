@extends('layouts.app')

@section('title', 'Tambah DUDI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3">
        <div class="card-header">
            <h5 class="mb-0">Tambah DUDI</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.dudi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control">{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('backend.dudi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

</div>
@endsection
