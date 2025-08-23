@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Siswa</h5>
            <a href="{{ route('backend.siswa.create') }}" class="btn btn-primary btn-sm">
                + Tambah Siswa
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Jurusan</th>
                        <th>Jenis Kelamin</th>
                        <th>No HP</th>
                        <th>Username (User)</th>
                        <th>Email (User)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nis }}</td>
                            <td>{{ $item->jurusan->jurusan ?? '-' }}</td> <!-- jurusan dari relasi -->
                            <td class="text-center">
                                {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </td>
                            <td>{{ $item->no_hp ?? '-' }}</td>
                            <td>{{ $item->user->username ?? '-' }}</td>
                            <td>{{ $item->user->email ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('backend.siswa.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                                <form action="{{ route('backend.siswa.destroy', $item->id) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
