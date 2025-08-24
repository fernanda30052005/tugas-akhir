@extends('layouts.app')

@section('title', 'Edit Logbook')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Logbook</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.logbook.update', $logbook->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Siswa (hanya untuk administrator) --}}
                @if(auth()->user()->role === 'administrator')
                <div class="mb-3">
                    <label for="siswa_id" class="form-label">Siswa</label>
                    <select class="form-control" id="siswa_id" name="siswa_id" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ $logbook->siswa_id == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->nama }} ({{ $siswa->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @else
                {{-- Nama Siswa otomatis untuk siswa --}}
                <div class="mb-3">
                    <label class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" value="{{ $logbook->siswa->nama }}" disabled>
                </div>
                @endif

                {{-- Tanggal --}}
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $logbook->tanggal }}" required>
                </div>

                {{-- Uraian Tugas pakai Summernote --}}
                <div class="mb-3">
                    <label for="uraian_tugas" class="form-label">Uraian Tugas</label>
                    <textarea id="uraian_tugas" name="uraian_tugas" class="form-control summernote" required>{{ $logbook->uraian_tugas }}</textarea>
                </div>

                {{-- Hasil / Output --}}
                <div class="mb-3">
                    <label for="hasil" class="form-label">Hasil / Output</label>
                    <textarea id="hasil" name="hasil" class="form-control" rows="3">{{ $logbook->hasil }}</textarea>
                </div>

                {{-- Dokumentasi File --}}
                <div class="mb-3">
                    <label for="dokumentasi" class="form-label">Upload Dokumentasi (PDF/IMG)</label>
                    @if($logbook->dokumentasi)
                        <p>
                            File sebelumnya: 
                            <a href="{{ asset('storage/'.$logbook->dokumentasi) }}" target="_blank">Lihat</a>
                        </p>
                    @endif
                    <input type="file" class="form-control" id="dokumentasi" name="dokumentasi">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('backend.logbook.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>
@endsection
