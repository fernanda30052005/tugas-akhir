@extends('layouts.app')

@section('title', 'Lihat Pengajuan Magang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pengajuan Magang</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Jurusan</th>
                        <th>DUDI</th>
                        <th>Tahun</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuan as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->siswa->jurusan->jurusan ?? '-' }}</td>
                            <td>{{ $item->dudi->nama }}</td>
                            <td>{{ $item->tahun->tahun_pelaksanaan }}</td>
                            <td>{{ $item->kuota }}</td>
                            <td>
                                @if($item->status == 'Pending')
                                    <span class="badge bg-warning">{{ $item->status }}</span>
                                @elseif($item->status == 'Diterima')
                                    <span class="badge bg-success">{{ $item->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'Pending')
                                    <form action="{{ route('backend.lihat_pengajuan.terima') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                    </form>
                                    <form action="{{ route('backend.lihat_pengajuan.tolak') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada pengajuan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
