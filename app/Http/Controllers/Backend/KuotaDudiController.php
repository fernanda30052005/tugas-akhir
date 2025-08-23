<?php

namespace App\Http\Controllers\Backend;

use App\Models\Dudi;
use App\Models\KuotaDudi;
use Illuminate\Http\Request;
use App\Models\TahunPelaksanaan;
use App\Http\Controllers\Controller;

class KuotaDudiController extends Controller
{
    public function index()
    {
        $kuota = KuotaDudi::with(['dudi', 'tahun'])->orderBy('tahun_id','desc')->get();
        return view('backend.kuota_dudi.index', compact('kuota'));
    }

    public function create()
{
    $kuota = KuotaDudi::all();

    // Struktur: [id_dudi => [tahun_id1, tahun_id2, ...]]
    $existing = $kuota->groupBy('id_dudi')->map(function($group){
        return $group->pluck('tahun_id')->toArray();
    })->toArray();

    $dudi = Dudi::all();
    $tahun = TahunPelaksanaan::orderBy('tahun_pelaksanaan', 'desc')->get();

    return view('backend.kuota_dudi.create', compact('dudi', 'tahun', 'existing'));
}


    public function store(Request $request)
    {
        $request->validate([
            'id_dudi' => 'required|exists:dudi,id',
            'tahun_id' => 'required|exists:tahun_pelaksanaan,id',
            'kuota' => 'required|integer|min:0',
        ]);

        // Cek apakah kombinasi id_dudi dan tahun_id sudah ada
        $existingKuota = KuotaDudi::where('id_dudi', $request->id_dudi)
                                 ->where('tahun_id', $request->tahun_id)
                                 ->first();

        if ($existingKuota) {
            return back()->withErrors([
                'id_dudi' => 'Kombinasi DUDI dan Tahun Pelaksanaan ini sudah ada dalam sistem. Silakan pilih kombinasi yang berbeda.'
            ])->withInput();
        }

        KuotaDudi::create($request->all());

        return redirect()->route('backend.kuota_dudi.index')->with('success','Kuota DUDI berhasil ditambahkan.');
    }

    public function edit(KuotaDudi $kuota_dudi)
    {
        $dudi = Dudi::all();
        return view('backend.kuota_dudi.edit', compact('kuota_dudi', 'dudi'));
    }

    public function update(Request $request, KuotaDudi $kuota_dudi)
    {
        $request->validate([
            'id_dudi' => 'required|exists:dudi,id',
            'kuota' => 'required|integer|min:0',
        ]);

        $kuota_dudi->update($request->all());

        return redirect()->route('backend.kuota_dudi.index')->with('success', 'Kuota DUDI berhasil diupdate.');
    }

    public function destroy(KuotaDudi $kuota_dudi)
    {
        $kuota_dudi->delete();
        return redirect()->route('backend.kuota_dudi.index')->with('success', 'Kuota DUDI berhasil dihapus.');
    }
}
