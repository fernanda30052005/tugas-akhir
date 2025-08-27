<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TahunPelaksanaan;
use Illuminate\Http\Request;

class TahunPelaksanaanController extends Controller
{
    public function index()
    {
        $tahun = TahunPelaksanaan::orderBy('tahun_pelaksanaan', 'desc')->get();
        return view('backend.tahun_pelaksanaan.index', compact('tahun'));
    }

    public function create()
    {
        return view('backend.tahun_pelaksanaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_pelaksanaan' => 'required|string|unique:tahun_pelaksanaan,tahun_pelaksanaan',
        ]);

        TahunPelaksanaan::create($request->all());

        return redirect()->route('backend.tahun_pelaksanaan.index')->with('success', 'Tahun Pelaksanaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tahun = TahunPelaksanaan::findOrFail($id);
        return view('backend.tahun_pelaksanaan.edit', compact('tahun'));
    }

    public function update(Request $request, $id)
    {
        $tahun = TahunPelaksanaan::findOrFail($id);
        
        $request->validate([
            'tahun_pelaksanaan' => 'required|string|unique:tahun_pelaksanaan,tahun_pelaksanaan,' . $id,
        ]);

        $tahun->update($request->all());

        return redirect()->route('backend.tahun_pelaksanaan.index')->with('success', 'Tahun Pelaksanaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tahun = TahunPelaksanaan::findOrFail($id);
        $tahun->delete();

        return redirect()->route('backend.tahun_pelaksanaan.index')->with('success', 'Tahun Pelaksanaan berhasil dihapus.');
    }
}
