@extends('layouts.app')

@section('title', 'Tahun Pelaksanaan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tahun Pelaksanaan</h5>
            <a href="{{ route('backend.tahun_pelaksanaan.create') }}" class="btn btn-primary btn-sm">+ Tambah Tahun</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Tahun Pelaksanaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahun as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tahun_pelaksanaan }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('backend.tahun_pelaksanaan.edit', $item->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('backend.tahun_pelaksanaan.destroy', $item->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                title="Hapus" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus tahun pelaksanaan ini?')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data tahun pelaksanaan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

