@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data Jurusan</h4>
        <a href="{{ route('backend.jurusan.create') }}" class="btn btn-primary btn-sm">
            + Tambah Jurusan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width:60px">#</th>
                        <th>Nama Jurusan</th>
                        <th style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jurusan as $idx => $j)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $j->jurusan }}</td>
                            <td>
                                <a href="{{ route('backend.jurusan.edit', $j->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('backend.jurusan.destroy', $j->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus jurusan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data jurusan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
