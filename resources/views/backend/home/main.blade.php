@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(isset($role) && $role === 'siswa')
            <h1>Dashboard Siswa</h1>
            
            @if(isset($studentData))
                <div class="row">
                    <!-- Student Information Card -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informasi Siswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Nama:</strong> {{ $studentData['nama'] }}
                                </div>
                                <div class="mb-3">
                                    <strong>NIS:</strong> {{ $studentData['nis'] }}
                                </div>
                                <div class="mb-3">
                                    <strong>Jurusan:</strong> {{ $studentData['jurusan'] }}
                                </div>
                                <div class="mb-3">
                                    <strong>Pembimbing:</strong> {{ $studentData['pembimbing'] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DUDI Information Card -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informasi Tempat Praktik (DUDI)</h4>
                            </div>
                            <div class="card-body">
                                @if(isset($dudiInfo) && $dudiInfo)
                                    <div class="mb-3">
                                        <strong>Nama DUDI:</strong> {{ $dudiInfo['nama_dudi'] }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Alamat:</strong> {{ $dudiInfo['alamat'] }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Status Pengajuan:</strong> 
                                        @if($dudiInfo['status'] == 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($dudiInfo['status'] == 'Diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif($dudiInfo['status'] == 'Ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $dudiInfo['status'] }}</span>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <p>Belum ada pengajuan magang yang disetujui.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <h4>Data siswa tidak ditemukan</h4>
                    <p>Profil siswa tidak dapat ditemukan untuk akun ini.</p>
                </div>
            @endif
        @elseif(isset($role) && $role === 'pembimbing')
            <h1>Dashboard Pembimbing</h1>
            
            @if(isset($pembimbingData))
                <div class="row">
                    <!-- Pembimbing Information Card -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Informasi Pembimbing</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong>Nama:</strong> {{ $pembimbingData['nama'] }}
                                </div>
                                <div class="mb-3">
                                    <strong>NIP:</strong> {{ $pembimbingData['nip'] }}
                                </div>
                                <div class="mb-3">
                                    <strong>Jenis Kelamin:</strong> {{ $pembimbingData['jenis_kelamin'] }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Students Supervised Card -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Siswa yang Dibimbing</h4>
                            </div>
                            <div class="card-body">
                                @if(isset($siswaBimbingan) && $siswaBimbingan->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>NIS</th>
                                                    <th>Jurusan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($siswaBimbingan as $siswa)
                                                    <tr>
                                                        <td>{{ $siswa->nama }}</td>
                                                        <td>{{ $siswa->nis }}</td>
                                                        <td>{{ $siswa->jurusan ? $siswa->jurusan->nama_jurusan : 'Belum ditentukan' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <p>Belum ada siswa yang dibimbing.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <h4>Data pembimbing tidak ditemukan</h4>
                    <p>Profil pembimbing tidak dapat ditemukan untuk akun ini.</p>
                </div>
            @endif
        @else
            
            <div class="row">
                <div class="col-md-4">
                    <h3>Total Siswa</h3>
                    <p id="total-siswa">{{ $totalSiswa }}</p>
                </div>
                <div class="col-md-4">
                    <h3>Total DUDI</h3>
                    <p id="total-dudi">{{ $totalDudi }}</p>
                </div>
                <div class="col-md-4">
                    <h3>Total Pengajuan</h3>
                    <p id="total-pengajuan">{{ $totalPengajuan }}</p>
                </div>
            </div>

            <div style="height: 400px;">
                <canvas id="myChart"></canvas>
            </div>
        @endif
    </div>

    @if(!isset($role) || ($role !== 'siswa' && $role !== 'pembimbing'))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($tahunPelaksanaan); ?>,
                        datasets: [{
                            label: 'Jumlah Pengajuan per Tahun',
                            data: <?php echo json_encode($jumlahPengajuan); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 0 // Disable animations to prevent "moving"
                        },
                        hover: {
                            animationDuration: 0 // Disable hover animations
                        },
                        responsiveAnimationDuration: 0, // Disable responsive animations
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0 // Show whole numbers only
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endsection
