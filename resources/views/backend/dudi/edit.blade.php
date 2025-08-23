@extends('layouts.app')

@section('title', 'Edit DUDI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3">
        <div class="card-header">
            <h5 class="mb-0">Edit DUDI</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.dudi.update', $dudi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $dudi->nama }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control">{{ $dudi->alamat }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $dudi->no_hp }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('dudi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

</div>
@endsection
