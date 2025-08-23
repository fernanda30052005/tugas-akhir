<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CapaianKompetensi;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class CapaianKompetensiController extends Controller
{
    public function index()
    {
        $kompetensi = CapaianKompetensi::with('jurusan')->orderBy('created_at','desc')->get();
        return view('backend.capaian_kompetensi.index', compact('kompetensi'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('backend.capaian_kompetensi.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kompetensi' => 'required|string|max:255',
            'status' => 'required|in:Ada,Tidak',
        ]);

        CapaianKompetensi::create($request->all());

        return redirect()->route('backend.capaian_kompetensi.index')->with('success','Capaian kompetensi berhasil ditambahkan.');
    }

    public function edit(CapaianKompetensi $capaian_kompetensi)
    {
        $jurusan = Jurusan::all();
        return view('backend.capaian_kompetensi.edit', compact('capaian_kompetensi','jurusan'));
    }

    public function update(Request $request, CapaianKompetensi $capaian_kompetensi)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kompetensi' => 'required|string|max:255',
            'status' => 'required|in:Ada,Tidak',
        ]);

        $capaian_kompetensi->update($request->all());

        return redirect()->route('backend.capaian_kompetensi.index')->with('success','Capaian kompetensi berhasil diupdate.');
    }

    public function destroy(CapaianKompetensi $capaian_kompetensi)
    {
        $capaian_kompetensi->delete();
        return redirect()->route('backend.capaian_kompetensi.index')->with('success','Capaian kompetensi berhasil dihapus.');
    }
}
