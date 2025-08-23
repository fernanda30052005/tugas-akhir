@extends('layouts.app')

@section('title', 'Data Logbook')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Logbook</h5>
            <a href="{{ route('backend.logbook.create') }}" class="btn btn-primary">Tambah Logbook</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>Uraian Tugas</th>
                        <th>Hasil</th>
                        <th>Dokumentasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logbooks as $logbook)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $logbook->siswa->nama }}</td>
                        <td>{{ $logbook->tanggal }}</td>
                        <td>{!! $logbook->uraian_tugas !!}</td>
                        <td>{{ $logbook->hasil }}</td>
                        <td>
                            @if($logbook->dokumentasi)
                                <a href="{{ asset('storage/'.$logbook->dokumentasi) }}" class="btn btn-success btn-sm" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('backend.logbook.edit', $logbook->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('backend.logbook.destroy', $logbook->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
