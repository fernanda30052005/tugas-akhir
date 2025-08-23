@extends('layouts.app')

@section('title', 'Buat Surat Pengantar Magang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Buat Surat Pengantar Magang</h5>
                    <a href="{{ route('backend.surat_pengantar.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-2"></i>
                        Kembali
                    </a>
                </div>

                <!-- Alert sukses -->
                @if(session('success'))
                    <div class="alert alert-success mx-3 mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Alert error -->
                @if($errors->any())
                    <div class="alert alert-danger mx-3 mt-3">
                        <strong>Error:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('backend.surat_pengantar.store') }}" method="POST">
                        @csrf

                        <!-- Lampiran & Perihal -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lampiran" class="form-label">Lampiran</label>
                                <input type="text" name="lampiran" id="lampiran" value="{{ old('lampiran') }}" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="perihal" class="form-label">Perihal</label>
                                <input type="text" name="perihal" id="perihal" value="{{ old('perihal') }}" class="form-control">
                            </div>
                        </div>

                        <!-- DUDI & Tahun -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dudi_id" class="form-label">Tempat Magang (DUDI) <span class="text-danger">*</span></label>
                                <select name="dudi_id" id="dudi_id" class="form-control @error('dudi_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih DUDI --</option>
                                    @foreach($dudi as $d)
                                        <option value="{{ $d->id }}" {{ old('dudi_id') == $d->id ? 'selected' : '' }}>
                                            {{ $d->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dudi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tahun_id" class="form-label">Tahun Pelaksanaan <span class="text-danger">*</span></label>
                                <select name="tahun_id" id="tahun_id" class="form-control @error('tahun_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach($tahun as $t)
                                        <option value="{{ $t->id }}" {{ old('tahun_id') == $t->id ? 'selected' : '' }}>
                                            {{ $t->tahun_pelaksanaan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Tanggal -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form-control @error('tanggal_mulai') is-invalid @enderror" required>
                                @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-control @error('tanggal_selesai') is-invalid @enderror" required>
                                @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Pilih Siswa -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Siswa <span class="text-danger">*</span></label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">Pilih</th>
                                            <th>Nama Siswa</th>
                                            <th>Jurusan</th>
                                            <th>Kelas</th>
                                            <th>Pembimbing</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswa as $student)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="siswa_id[]" value="{{ $student->id }}"
                                                        {{ is_array(old('siswa_id')) && in_array($student->id, old('siswa_id')) ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $student->nama }}</td>
                                                <td>{{ $student->jurusan?->jurusan ?? '-' }}</td>
                                                <td>
                                                    <input type="text" name="kelas[{{ $student->id }}]" class="form-control" placeholder="Kelas" value="{{ old('kelas.'.$student->id, 'XII') }}">
                                                </td>
                                                <td>
                                                    @if($student->pembimbing)
                                                        <input type="text" name="pembimbing[{{ $student->id }}]" class="form-control" value="{{ $student->pembimbing->nama }}" readonly>
                                                        <input type="hidden" name="pembimbing_id[{{ $student->id }}]" value="{{ $student->pembimbing->id }}">
                                                    @else
                                                        <input type="text" name="pembimbing[{{ $student->id }}]" class="form-control" placeholder="Belum ada pembimbing" readonly style="background-color: #f8f9fa;">
                                                        <small class="text-muted">Atur pembimbing terlebih dahulu</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @error('siswa_id') <div class="text-danger mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                <i class="bx bx-printer me-2"></i>
                                Buat Surat Pengantar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
