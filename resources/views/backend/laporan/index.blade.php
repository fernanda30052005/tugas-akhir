@extends('layouts.app')

@section('title', 'Laporan Magang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Laporan Magang</h3>

    {{-- Hanya siswa yang bisa upload --}}
    @if(auth()->user()->role === 'siswa')
    <div class="card mb-4">
        <div class="card-header">Upload Laporan</div>
        <div class="card-body">
            <form action="{{ route('backend.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Judul Laporan</label>
                    <input type="text" name="judul_laporan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>File Laporan (PDF)</label>
                    <input type="file" name="file_laporan" class="form-control" accept="application/pdf" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-header">Daftar Laporan</div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal Upload</th>
                        @if(auth()->user()->role !== 'siswa')
                            <th>Nama Siswa</th>
                        @endif
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporan as $item)
                        <tr>
                            <td>{{ $item->judul_laporan }}</td>
                            <td>{{ $item->tanggal_upload }}</td>
                            @if(auth()->user()->role !== 'siswa')
                                <td>{{ $item->siswa->nama ?? '-' }}</td>
                            @endif
                            <td>
                                <a href="{{ route('backend.laporan.download', $item->id) }}" class="btn btn-success btn-sm">Download</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
