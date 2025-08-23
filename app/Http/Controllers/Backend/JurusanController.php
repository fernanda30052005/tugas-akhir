<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('backend.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('backend.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan' => 'required|string|max:100|unique:jurusan,jurusan',
        ]);

        Jurusan::create($request->only('jurusan'));

        return redirect()->route('backend.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('backend.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $request->validate([
            'jurusan' => 'required|string|max:100|unique:jurusan,jurusan,' . $jurusan->id,
        ]);

        $jurusan->update($request->only('jurusan'));

        return redirect()->route('backend.jurusan.index')->with('success', 'Jurusan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('backend.jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}
