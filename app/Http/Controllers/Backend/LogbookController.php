<?php

namespace App\Http\Controllers\Backend;

use App\Models\Siswa;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogbookController 
{
    public function index()
    {
        $logbooks = Logbook::with('siswa')->latest()->paginate(10);
        return view('backend.logbook.index', compact('logbooks'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        return view('backend.logbook.create', compact('siswas'));
    }


public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'uraian_tugas' => 'required|string',
        'hasil' => 'nullable|string',
        'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $siswa = Auth::user()->siswa; // ambil data siswa dari user yang login

    $logbook = new Logbook();
    $logbook->siswa_id = $siswa->id;
    $logbook->tanggal = $request->tanggal;
    $logbook->uraian_tugas = $request->uraian_tugas;
    $logbook->hasil = $request->hasil;

    if ($request->hasFile('dokumentasi')) {
        $logbook->dokumentasi = $request->file('dokumentasi')->store('logbook', 'public');
    }

    $logbook->save();

    return redirect()->route('backend.logbook.index')->with('success', 'Logbook berhasil ditambahkan!');
}


    public function show(Logbook $logbook)
    {
        return view('backend.logbook.show', compact('logbook'));
    }

    public function edit(Logbook $logbook)
    {
        $siswas = Siswa::all();
        return view('backend.logbook.edit', compact('logbook','siswas'));
    }

    public function update(Request $request, Logbook $logbook)
{
    $request->validate([
        'tanggal' => 'required|date',
        'uraian_tugas' => 'required|string',
        'hasil' => 'nullable|string',
        'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $logbook->tanggal = $request->tanggal;
    $logbook->uraian_tugas = $request->uraian_tugas;
    $logbook->hasil = $request->hasil;

    if ($request->hasFile('dokumentasi')) {
        $logbook->dokumentasi = $request->file('dokumentasi')->store('logbook', 'public');
    }

    $logbook->save();

    return redirect()->route('backend.logbook.index')->with('success', 'Logbook berhasil diperbarui!');
}

    public function destroy(Logbook $logbook)
    {
        $logbook->delete();
        return redirect()->route('backend.logbook.index')->with('success', 'Logbook berhasil dihapus');
    }
}