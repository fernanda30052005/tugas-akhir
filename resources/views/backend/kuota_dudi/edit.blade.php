@extends('layouts.app')

@section('title', 'Edit Kuota DUDI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Kuota DUDI</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.kuota_dudi.update', $kuota_dudi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-floating mb-3">
                    <select name="id_dudi" class="form-select" id="dudiSelect" required>
                        <option value="">-- Pilih DUDI --</option>
                        @foreach($dudi as $item)
                            <option value="{{ $item->id }}" {{ $kuota_dudi->id_dudi == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    <label for="dudiSelect">DUDI</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" name="kuota" class="form-control" id="kuotaInput" min="0" value="{{ $kuota_dudi->kuota }}" required>
                    <label for="kuotaInput">Kuota</label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('backend.kuota_dudi.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
