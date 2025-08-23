@extends('layouts.app')

@section('title', 'Data Pembimbing')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pembimbing</h5>
            <a href="{{ route('backend.pembimbing.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Tambah Pembimbing
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembimbing as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->nip }}</td>
                                <td>{{ $p->jenis_kelamin }}</td>
                                <td>{{ $p->email }}</td>
                                <td>
                                    <a href="{{ route('backend.pembimbing.edit', $p->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bx bx-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('backend.pembimbing.destroy', $p->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pembimbing ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data pembimbing</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
