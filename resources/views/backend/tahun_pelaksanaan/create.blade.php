@extends('layouts.app')

@section('title', 'Tambah Tahun Pelaksanaan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3 mx-auto" style="max-width: 500px;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Tahun Pelaksanaan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.tahun_pelaksanaan.store') }}" method="POST">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="tahun_pelaksanaan" class="form-control" id="tahunInput" placeholder="Tahun Pelaksanaan" value="{{ old('tahun_pelaksanaan') }}" required>
                    <label for="tahunInput">Tahun Pelaksanaan</label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('backend.tahun_pelaksanaan.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

