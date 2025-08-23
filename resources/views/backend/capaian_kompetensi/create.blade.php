@extends('layouts.app')

@section('title', 'Tambah Capaian Kompetensi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3">
        <div class="card-header">
            <h5 class="mb-0">Tambah Capaian Kompetensi</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('backend.capaian_kompetensi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jurusan_id" class="form-label">Jurusan</label>
                    <select name="jurusan_id" class="form-control" required>
                        @foreach($jurusan as $j)
                            <option value="{{ $j->id }}">{{ $j->jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_kompetensi" class="form-label">Nama Kompetensi</label>
                    <input type="text" name="nama_kompetensi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Ada">Ada</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('backend.capaian_kompetensi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

</div>
@endsection

