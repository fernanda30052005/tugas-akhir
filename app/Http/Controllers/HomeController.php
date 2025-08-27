<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Dudi;
use App\Models\PengajuanMagang;
use App\Models\TahunPelaksanaan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $role = $user->role;

        // Handle different roles
        if ($role === 'siswa') {
            // Get student data
            $siswa = $user->siswa;
            
            if ($siswa) {
                // Get student information
                $studentData = [
                    'nama' => $siswa->nama,
                    'nis' => $siswa->nis,
                    'jurusan' => $siswa->jurusan ? $siswa->jurusan->jurusan : 'Belum ditentukan',
                    'pembimbing' => $siswa->pembimbing ? $siswa->pembimbing->nama : 'Belum ditentukan'
                ];

                // Get DUDI information from pengajuan magang
                $pengajuan = $siswa->pengajuanMagang()->latest()->first();
                $dudiInfo = null;
                
                if ($pengajuan && $pengajuan->dudi) {
                    $dudiInfo = [
                        'nama_dudi' => $pengajuan->dudi->nama,
                        'alamat' => $pengajuan->dudi->alamat,
                        'status' => $pengajuan->status
                    ];
                }

                return view('backend.home.main', compact('studentData', 'dudiInfo', 'role'));
            }
        } elseif ($role === 'pembimbing') {
            // Get pembimbing data
            $pembimbing = $user->pembimbing;
            
            if ($pembimbing) {
                // Get pembimbing information
                $pembimbingData = [
                    'nama' => $pembimbing->nama,
                    'nip' => $pembimbing->nip,
                    'jenis_kelamin' => $pembimbing->jenis_kelamin
                ];

                // Get students supervised by this pembimbing
                $siswaBimbingan = $pembimbing->siswa()->with('jurusan')->get();

                return view('backend.home.main', compact('pembimbingData', 'siswaBimbingan', 'role'));
            }
        }

        // Default admin dashboard
        $totalSiswa = Siswa::count();
        $totalDudi = Dudi::count();
        $totalPengajuan = PengajuanMagang::count();

        // Get data for chart - pengajuan per tahun pelaksanaan
        $tahunPelaksanaan = TahunPelaksanaan::pluck('tahun_pelaksanaan')->toArray();
        $jumlahPengajuan = [];

        foreach ($tahunPelaksanaan as $tahun) {
            $jumlah = PengajuanMagang::whereHas('tahun', function($query) use ($tahun) {
                $query->where('tahun_pelaksanaan', $tahun);
            })->count();
            $jumlahPengajuan[] = $jumlah;
        }

        return view('backend.home.main', compact(
            'totalSiswa',
            'totalDudi',
            'totalPengajuan',
            'tahunPelaksanaan',
            'jumlahPengajuan',
            'role'
        ));
    }
}
