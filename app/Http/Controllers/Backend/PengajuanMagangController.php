<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PengajuanMagang;
use App\Models\KuotaDudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanMagangController extends Controller
{
    // Tampilkan daftar DUDI + tombol usulkan
    public function index()
    {
        $kuota = KuotaDudi::with(['dudi','tahun'])->get();

        // Pengajuan user login
        $userUsulan = PengajuanMagang::where('user_id', Auth::id())
            ->pluck('id_dudi','tahun_id')
            ->toArray();

        return view('backend.pengajuan_magang.index', compact('kuota','userUsulan'));
    }

    // Action usulkan
    public function usulkan(Request $request)
    {
        $userId = Auth::id();
        $idDudi = $request->id_dudi;
        $tahunId = $request->tahun_id;

        $kuotaDudi = KuotaDudi::where('id_dudi',$idDudi)->where('tahun_id',$tahunId)->first();
        if(!$kuotaDudi){
            return redirect()->back()->with('error','Kuota DUDI tidak ditemukan.');
        }

        $terpakai = PengajuanMagang::where('id_dudi',$idDudi)
                    ->where('tahun_id',$tahunId)
                    ->count();

        if($terpakai >= $kuotaDudi->kuota){
            return redirect()->back()->with('error','Kuota sudah penuh.');
        }

        $already = PengajuanMagang::where('user_id',$userId)
                    ->where('id_dudi',$idDudi)
                    ->where('tahun_id',$tahunId)
                    ->first();

        if($already){
            return redirect()->back()->with('error','Kamu sudah mengusulkan magang di DUDI ini untuk tahun ini.');
        }

        PengajuanMagang::create([
            'user_id' => $userId,
            'id_dudi' => $idDudi,
            'tahun_id' => $tahunId,
            'kuota' => $kuotaDudi->kuota
        ]);

        return redirect()->back()->with('success','Berhasil mengusulkan magang.');
    }

    // Action batalkan usulan
    public function batalkan(Request $request)
    {
        $userId = Auth::id();
        $idDudi = $request->id_dudi;
        $tahunId = $request->tahun_id;

        $pengajuan = PengajuanMagang::where('user_id',$userId)
                        ->where('id_dudi',$idDudi)
                        ->where('tahun_id',$tahunId)
                        ->first();

        if($pengajuan){
            $pengajuan->delete();
            return redirect()->back()->with('success','Usulan magang dibatalkan.');
        }

        return redirect()->back()->with('error','Usulan tidak ditemukan.');
    }
    public function lihatPengajuan()
    {
        $pengajuan = PengajuanMagang::with(['user.siswa.jurusan','dudi','tahun'])
                    ->orderBy('tahun_id','desc')
                    ->get();

    return view('backend.pengajuan_magang.lihat', compact('pengajuan'));
    }

    public function terimaUsulan(Request $request)
    {
        $id = $request->id;
        $pengajuan = PengajuanMagang::findOrFail($id);

        $pengajuan->update(['status' => 'Diterima']); // pastikan ada kolom status di migration

    return redirect()->back()->with('success','Usulan berhasil diterima.');
    }

    public function tolakUsulan(Request $request)
    {
        $id = $request->id;
        $pengajuan = PengajuanMagang::findOrFail($id);

        $pengajuan->update(['status' => 'Ditolak']); // pastikan ada kolom status di migration

        return redirect()->back()->with('success','Usulan berhasil ditolak.');
    }

}
