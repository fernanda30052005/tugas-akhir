@extends('layouts.app')

@section('title', 'Upload Laporan Magang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Upload Laporan Magang</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul_laporan" class="form-label">Judul Laporan</label>
                    <input type="text" name="judul_laporan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="file_laporan" class="form-label">Upload Laporan (PDF)</label>
                    <input type="file" name="file_laporan" class="form-control" accept="application/pdf" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('backend.laporan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
