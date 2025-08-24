<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Tampilkan semua data siswa
     */
    public function index()
    {
        $siswa = Siswa::with('jurusan', 'user')->get();
        return view('backend.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $jurusan = Jurusan::all(); // ambil semua jurusan
        return view('backend.siswa.create', compact('jurusan'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nis' => 'required|unique:siswa',
        'jurusan_id' => 'required|exists:jurusan,id',
        'jenis_kelamin' => 'required',
        'no_hp' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    // 1. Buat user baru dengan role siswa
    $user = \App\Models\User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'siswa',
    ]);
    
    // Assign role siswa ke user
    $user->assignRole('siswa');

    // 2. Buat data siswa terkait user
    Siswa::create([
        'user_id' => $user->id,
        'nama' => $request->nama,
        'nis' => $request->nis,
        'jurusan_id' => $request->jurusan_id,
        'jenis_kelamin' => $request->jenis_kelamin,
        'no_hp' => $request->no_hp,
        'pembimbing_id' => $request->pembimbing_id,
    ]);

    return redirect()->route('backend.siswa.index')
                     ->with('success', 'Siswa berhasil ditambahkan.');
}


    public function edit($id)
    {
        $siswa = Siswa::find($id);
        $jurusan = Jurusan::all(); // ✅ dropdown jurusan juga tersedia

        if (is_null($siswa)) {
            return redirect()->route('backend.siswa.index')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        return view('backend.siswa.edit', compact('siswa', 'jurusan'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (is_null($siswa)) {
            return redirect()->route('backend.siswa.index')
                ->with('error', 'Data siswa tidak ditemukan.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswa,nis,' . $siswa->id,
            'jurusan_id' => 'required|exists:jurusan,id', // ✅ validasi id jurusan
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'password' => 'nullable|string|min:6'
        ]);

        $user = $siswa->user;
        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
        ]);

        $siswa->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'jurusan_id' => $request->jurusan_id, // ✅ update id jurusan
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('backend.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }
}
