@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5>Edit Siswa</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('backend.siswa.partials.form')
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('backend.siswa.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
