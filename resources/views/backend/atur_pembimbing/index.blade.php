@extends('layouts.app')

@section('title', 'Atur Pembimbing Siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Alert sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alert error validasi -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Atur Pembimbing Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Jurusan</th>
                            <th>Pembimbing Saat Ini</th>
                            <th>Pilih Pembimbing</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->jurusan->jurusan ?? '-' }}</td>
                                <td>{{ $item->pembimbing->nama ?? 'Belum ada pembimbing' }}</td>
                                <td>
                                    <form action="{{ route('backend.atur_pembimbing.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="pembimbing_id" class="form-select form-select-sm @error('pembimbing_id') is-invalid @enderror">
                                            <option value="">-- Pilih Pembimbing --</option>
                                            @foreach($pembimbing as $p)
                                                <option value="{{ $p->id }}" {{ old('pembimbing_id', $item->pembimbing_id) == $p->id ? 'selected' : '' }}>
                                                    {{ $p->nama }} 
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('pembimbing_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </td>
                                <td>
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data siswa</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
