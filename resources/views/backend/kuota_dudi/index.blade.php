@extends('layouts.app')

@section('title', 'Kuota DUDI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Kuota DUDI</h5>
            <a href="{{ route('backend.kuota_dudi.create') }}" class="btn btn-primary btn-sm">+ Tambah Kuota</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>DUDI</th>
                        <th>Tahun Pelaksanaan</th>
                        <th>Kuota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kuota as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->dudi->nama }}</td>
                            <td>{{ $item->tahun->tahun_pelaksanaan }}</td>
                            <td>{{ $item->kuota }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data kuota</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
