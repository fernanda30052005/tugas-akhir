@extends('layouts.app')

@section('title', 'Pengajuan Magang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3">
        <div class="card-header">
            <h5 class="mb-0">Daftar DUDI</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>No</th>
                        <th>DUDI</th>
                        <th>Tahun</th>
                        <th>Kuota</th>
                        <th>Terpakai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kuota as $item)
                        @php
                            $terpakai = \App\Models\PengajuanMagang::where('id_dudi',$item->id_dudi)->where('tahun_id',$item->tahun_id)->count();
                            $userApplication = \App\Models\PengajuanMagang::where('user_id',auth()->id())
                                            ->where('id_dudi',$item->id_dudi)
                                            ->where('tahun_id',$item->tahun_id)
                                            ->first();
                            $userAlready = $userApplication ? true : false;
                        @endphp
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->dudi->nama }}</td>
                            <td>{{ $item->tahun->tahun_pelaksanaan }}</td>
                            <td>{{ $item->kuota }}</td>
                            <td>{{ $terpakai }}</td>
                            <td>
                                @if($userAlready)
                                    @if($userApplication->status == 'Pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($userApplication->status == 'Diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($userApplication->status == 'Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($userAlready)
                                    <form action="{{ route('backend.pengajuan_magang.batalkan') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_dudi" value="{{ $item->id_dudi }}">
                                        <input type="hidden" name="tahun_id" value="{{ $item->tahun_id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Batalkan Usulan</button>
                                    </form>
                                @elseif($terpakai < $item->kuota)
                                    <form action="{{ route('backend.pengajuan_magang.usulkan') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_dudi" value="{{ $item->id_dudi }}">
                                        <input type="hidden" name="tahun_id" value="{{ $item->tahun_id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Usulkan</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Kuota Penuh</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
