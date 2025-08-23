<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PembimbingController extends Controller
{
     public function index()
    {
        $pembimbing = Pembimbing::with('user')->get();
        return view('backend.pembimbing.index', compact('pembimbing'));
    }

    public function create()
    {
        return view('backend.pembimbing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nip'           => 'required|string|max:50|unique:pembimbing',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
        ]);

        // simpan ke tabel users
        $user = User::create([
            'name'     => $request->nama,
            'username' => $request->nip,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pembimbing',
        ]);

        // simpan ke tabel pembimbing
        Pembimbing::create([
            'user_id'       => $user->id,
            'nama'          => $request->nama,
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('backend.pembimbing.index')
            ->with('success', 'Pembimbing berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pembimbing = Pembimbing::with('user')->findOrFail($id);
        return view('backend.pembimbing.edit', compact('pembimbing'));
    }

    public function update(Request $request, $id)
    {
        $pembimbing = Pembimbing::with('user')->findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'nip'           => 'required|string|max:50|unique:pembimbing,nip,' . $pembimbing->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'username'      => 'required|string|max:50|unique:users,username,' . $pembimbing->user_id,
            'email'         => 'required|email|unique:users,email,' . $pembimbing->user_id,
            'password'      => 'nullable|string|min:6',
        ]);

        // update user
        $pembimbing->user->update([
            'username' => $request->username,
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password 
                ? Hash::make($request->password) 
                : $pembimbing->user->password,
        ]);

        // update pembimbing
        $pembimbing->update([
            'nama'          => $request->nama,
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('backend.pembimbing.index')
            ->with('success', 'Pembimbing berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pembimbing = Pembimbing::findOrFail($id);
        $pembimbing->user->delete();
        $pembimbing->delete();

        return redirect()->route('backend.pembimbing.index')
            ->with('success', 'Pembimbing berhasil dihapus');
    }
}
