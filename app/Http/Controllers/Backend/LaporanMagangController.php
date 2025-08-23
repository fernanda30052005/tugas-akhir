<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LaporanMagang;
use Illuminate\Http\Request;

class LaporanMagangController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'siswa') {
            // siswa hanya lihat laporan miliknya
            $laporan = LaporanMagang::where('siswa_id', auth()->user()->siswa->id)->get();
        } else {
            // admin bisa lihat semua laporan siswa
            $laporan = LaporanMagang::with('siswa')->get();
        }

        return view('backend.laporan.index', compact('laporan'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'siswa') {
            return redirect()->back()->with('error', 'Hanya siswa yang bisa upload laporan.');
        }

        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'file_laporan'  => 'required|mimes:pdf|max:2048',
        ]);

        $siswa = auth()->user()->siswa;

        if (!$siswa) {
            return redirect()->back()->with('error', 'Akun ini belum terhubung dengan data siswa.');
        }

        $fileName = time() . '_' . $request->file('file_laporan')->getClientOriginalName();
        $path = $request->file('file_laporan')->storeAs('laporan', $fileName, 'public');

        LaporanMagang::create([
            'siswa_id'       => $siswa->id,
            'judul_laporan'  => $request->judul_laporan,
            'file_laporan'   => $path,
            'tanggal_upload' => now(),
        ]);

        return redirect()->route('backend.laporan.index')->with('success', 'Laporan berhasil diupload');
    }

    public function download($id)
    {
        $laporan = LaporanMagang::findOrFail($id);

        return response()->download(storage_path('app/public/' . $laporan->file_laporan));
    }
}
