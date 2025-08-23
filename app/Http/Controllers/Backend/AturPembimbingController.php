<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pembimbing;
use Illuminate\Http\Request;

class AturPembimbingController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('pembimbing', 'jurusan')->get();
        $pembimbing = Pembimbing::all();
        
        return view('backend.atur_pembimbing.index', compact('siswa', 'pembimbing'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pembimbing_id' => 'nullable|exists:pembimbing,id' // ✅ perbaiki ke pembimbings
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'pembimbing_id' => $request->pembimbing_id
        ]);

        return redirect()->route('backend.atur_pembimbing.index')
            ->with('success', 'Pembimbing berhasil diatur untuk siswa.');
    }
}
