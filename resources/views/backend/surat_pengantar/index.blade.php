@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Surat Pengantar Magang</h5>
          <a href="{{ route('backend.surat_pengantar.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i>
            Buat Surat Baru
          </a>
        </div>
        
        @if(session('success'))
          <div class="alert alert-success mx-3 mt-3">
            <i class="bx bx-check-circle me-2"></i>
            {{ session('success') }}
          </div>
        @endif

        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info">
                <i class="bx bx-info-circle me-2"></i>
                <strong>Petunjuk:</strong>
                <ul class="mb-0 mt-2">
                  <li>Klik "Buat Surat Baru" untuk membuat surat pengantar magang</li>
                  <li>Pilih tempat magang (DUDI)</li>
                  <li>Pilih tahun pelaksanaan</li>
                  <li>Pilih siswa yang akan magang di tempat yang sama</li>
                  <li>Siswa dengan tempat magang yang sama akan digabung dalam satu surat</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-12">
              <h6>Daftar Surat Pengantar</h6>
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead class="table-light">
                    <tr>
                      <th>No</th>
                      <th>Nomor Surat</th>
                      <th>DUDI</th>
                      <th>Tahun</th>
                      <th>Jumlah Siswa</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($surat as $s)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->nomor_surat }}</td>
                        <td>{{ $s->dudi?->nama ?? '-' }}</td>
                        <td>{{ $s->tahun?->tahun_pelaksanaan ?? '-' }}</td>
                        <td>{{ $s->siswa->count() }} siswa</td>
                        <td>
                          <a href="{{ route('backend.surat_pengantar.show', $s->id) }}" class="btn btn-sm btn-info">
                            <i class="bx bx-show me-1"></i> Lihat
                          </a>
                          <a href="{{ route('backend.surat_pengantar.download', $s->id) }}" class="btn btn-sm btn-success">
                            <i class="bx bx-download me-1"></i> PDF
                          </a>
                          <form action="{{ route('backend.surat_pengantar.destroy', $s->id) }}" 
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus surat ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                              <i class="bx bx-trash me-1"></i> Hapus
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center">Belum ada surat pengantar dibuat</td>
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
  </div>
</div>
@endsection
