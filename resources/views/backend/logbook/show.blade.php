@extends('layouts.app')

@section('title', 'Detail Logbook')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5>Detail Logbook</h5>
        </div>
        <div class="card-body">
            <p><strong>Siswa:</strong> {{ $logbook->siswa->nama }}</p>
            <p><strong>Tanggal:</strong> {{ $logbook->tanggal }}</p>
            <p><strong>Uraian Tugas:</strong> {{ $logbook->uraian_tugas }}</p>
            <p><strong>Hasil Output:</strong> {{ $logbook->hasil_output }}</p>
            <p><strong>Dokumentasi:</strong>
                @if($logbook->dokumentasi)
                    <a href="{{ asset('storage/' . $logbook->dokumentasi) }}" target="_blank">Lihat Dokumentasi</a>
                @else
                    -
                @endif
            </p>
            <a href="{{ route('backend.logbook.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
