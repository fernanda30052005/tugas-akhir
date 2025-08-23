<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dudi;
use Illuminate\Http\Request;

class DudiController extends Controller
{
    public function index()
    {
        $dudi = Dudi::all();
        return view('backend.dudi.index', compact('dudi'));
    }

    public function create()
    {
        return view('backend.dudi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        Dudi::create($request->all());

        return redirect()->route('backend.dudi.index')->with('success', 'DUDI berhasil ditambahkan.');
    }

    public function edit(Dudi $dudi)
    {
        return view('backend.dudi.edit', compact('dudi'));
    }

    public function update(Request $request, Dudi $dudi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $dudi->update($request->all());

        return redirect()->route('backend.dudi.index')->with('success', 'DUDI berhasil diupdate.');
    }

    public function destroy(Dudi $dudi)
    {
        $dudi->delete();
        return redirect()->route('backend.dudi.index')->with('success', 'DUDI berhasil dihapus.');
    }
}
