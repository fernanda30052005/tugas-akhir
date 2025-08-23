@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Detail Surat Pengantar</h5>
          <div>
            <a href="{{ route('backend.surat_pengantar.index') }}" class="btn btn-secondary btn-sm">
              <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
            <a href="{{ route('backend.surat_pengantar.download', $surat_pengantar->id) }}" class="btn btn-success btn-sm">
              <i class="bx bx-download me-1"></i> Download PDF
            </a>
          </div>
        </div>

        <div class="card-body">
          <!-- Info Surat -->
          <div class="row mb-3">
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <th width="35%">Nomor Surat</th>
                  <td>: {{ $surat_pengantar->nomor_surat }}</td>
                </tr>
                <tr>
                  <th>Lampiran</th>
                  <td>: {{ $surat_pengantar->lampiran ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Perihal</th>
                  <td>: {{ $surat_pengantar->perihal ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Tempat Magang (DUDI)</th>
                  <td>: {{ $surat_pengantar->dudi?->nama ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Alamat DUDI</th>
                  <td>: {{ $surat_pengantar->dudi?->alamat ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Tahun Pelaksanaan</th>
                  <td>: {{ $surat_pengantar->tahun?->tahun_pelaksanaan ?? '-' }}</td>
                </tr>
                <tr>
                  <th>Tanggal Mulai</th>
                  <td>: {{ $surat_pengantar->tanggal_mulai }}</td>
                </tr>
                <tr>
                  <th>Tanggal Selesai</th>
                  <td>: {{ $surat_pengantar->tanggal_selesai }}</td>
                </tr>
              </table>
            </div>
          </div>

          <!-- Daftar Siswa -->
          <h6>Daftar Siswa</h6>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>Jurusan</th>
                  <th>Kelas</th>
                  <th>Pembimbing</th>
                </tr>
              </thead>
              <tbody>
                @forelse($surat_pengantar->siswa as $i => $s)
                  <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->jurusan?->jurusan ?? '-' }}</td>
                    <td>{{ $s->pivot->kelas ?? '-' }}</td>
                    <td>{{ $s->pivot->pembimbing ?? '-' }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">Belum ada siswa terdata</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
