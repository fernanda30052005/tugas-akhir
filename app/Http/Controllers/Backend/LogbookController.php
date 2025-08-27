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
        $user = Auth::user();
        
        if ($user->role === 'siswa') {
            // Siswa hanya melihat logbook miliknya sendiri
            $siswa = $user->siswa;
            if (!$siswa) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            $logbooks = Logbook::where('siswa_id', $siswa->id)->latest()->paginate(10);
        } elseif ($user->role === 'pembimbing') {
            // Pembimbing melihat logbook siswa yang dibimbingnya
            $pembimbing = $user->pembimbing;
            if (!$pembimbing) {
                return redirect()->back()->with('error', 'Data pembimbing tidak ditemukan.');
            }
            $logbooks = Logbook::whereHas('siswa', function($query) use ($pembimbing) {
                $query->where('pembimbing_id', $pembimbing->id);
            })->with('siswa')->latest()->paginate(10);
        } else {
            // Administrator melihat semua logbook
            $logbooks = Logbook::with('siswa')->latest()->paginate(10);
        }
        
        return view('backend.logbook.index', compact('logbooks'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if ($user->role === 'siswa') {
            // Siswa tidak perlu memilih siswa, otomatis menggunakan data mereka sendiri
            return view('backend.logbook.create');
        } elseif ($user->role === 'administrator') {
            // Administrator bisa memilih siswa
            $siswas = Siswa::all();
            return view('backend.logbook.create', compact('siswas'));
        } else {
            // Pembimbing tidak bisa membuat logbook
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk membuat logbook.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian_tugas' => 'required|string',
            'hasil_output' => 'nullable|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();
        
        if ($user->role === 'siswa') {
            $siswa = $user->siswa;
            if (!$siswa) {
                return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
            }
            $siswa_id = $siswa->id;
        } elseif ($user->role === 'administrator') {
            $siswa_id = $request->siswa_id;
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk membuat logbook.');
        }

        $logbook = new Logbook();
        $logbook->siswa_id = $siswa_id;
        $logbook->tanggal = $request->tanggal;
        $logbook->uraian_tugas = $request->uraian_tugas;
        $logbook->hasil_output = $request->hasil_output;

        if ($request->hasFile('dokumentasi')) {
            $logbook->dokumentasi = $request->file('dokumentasi')->store('logbook', 'public');
        }

        $logbook->save();

        return redirect()->route('backend.logbook.index')->with('success', 'Logbook berhasil ditambahkan!');
    }

    public function show(Logbook $logbook)
    {
        $user = Auth::user();
        
        // Cek akses berdasarkan role
        if ($user->role === 'siswa') {
            $siswa = $user->siswa;
            if (!$siswa || $logbook->siswa_id !== $siswa->id) {
                abort(403, 'Unauthorized access');
            }
        } elseif ($user->role === 'pembimbing') {
            $pembimbing = $user->pembimbing;
            if (!$pembimbing || $logbook->siswa->pembimbing_id !== $pembimbing->id) {
                abort(403, 'Unauthorized access');
            }
        }
        // Administrator bisa melihat semua logbook
        
        return view('backend.logbook.show', compact('logbook'));
    }

    public function edit(Logbook $logbook)
    {
        $user = Auth::user();
        
        // Cek akses berdasarkan role
        if ($user->role === 'siswa') {
            $siswa = $user->siswa;
            if (!$siswa || $logbook->siswa_id !== $siswa->id) {
                abort(403, 'Unauthorized access');
            }
            return view('backend.logbook.edit', compact('logbook'));
        } elseif ($user->role === 'administrator') {
            $siswas = Siswa::all();
            return view('backend.logbook.edit', compact('logbook', 'siswas'));
        } else {
            abort(403, 'Unauthorized access');
        }
    }

    public function update(Request $request, Logbook $logbook)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian_tugas' => 'required|string',
            'hasil_output' => 'nullable|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();
        
        // Cek akses berdasarkan role
        if ($user->role === 'siswa') {
            $siswa = $user->siswa;
            if (!$siswa || $logbook->siswa_id !== $siswa->id) {
                abort(403, 'Unauthorized access');
            }
        } elseif ($user->role === 'administrator') {
            $logbook->siswa_id = $request->siswa_id;
        } else {
            abort(403, 'Unauthorized access');
        }

        $logbook->tanggal = $request->tanggal;
        $logbook->uraian_tugas = $request->uraian_tugas;
        $logbook->hasil_output = $request->hasil_output;

        if ($request->hasFile('dokumentasi')) {
            $logbook->dokumentasi = $request->file('dokumentasi')->store('logbook', 'public');
        }

        $logbook->save();

        return redirect()->route('backend.logbook.index')->with('success', 'Logbook berhasil diperbarui!');
    }

    public function destroy(Logbook $logbook)
    {
        $user = Auth::user();
        
        // Cek akses berdasarkan role
        if ($user->role === 'siswa') {
            $siswa = $user->siswa;
            if (!$siswa || $logbook->siswa_id !== $siswa->id) {
                abort(403, 'Unauthorized access');
            }
        } elseif ($user->role === 'pembimbing') {
            abort(403, 'Unauthorized access');
        }
        // Administrator bisa menghapus semua logbook
        
        $logbook->delete();
        return redirect()->route('backend.logbook.index')->with('success', 'Logbook berhasil dihapus');
    }
}
