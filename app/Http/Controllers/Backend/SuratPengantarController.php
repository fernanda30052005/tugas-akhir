<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SuratPengantar;
use App\Models\Dudi;
use App\Models\Siswa;
use App\Models\TahunPelaksanaan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratPengantarController extends Controller
{
    public function index()
    {
        $surat = SuratPengantar::with(['dudi','tahun','siswa.pembimbing'])->orderBy('created_at','desc')->get();
        return view('backend.surat_pengantar.index', compact('surat'));
    }

    public function create()
    {
        $dudi = Dudi::all();
        $tahun = TahunPelaksanaan::orderBy('tahun_pelaksanaan','desc')->get();
        $siswa = Siswa::with(['jurusan', 'pembimbing'])->get();

        return view('backend.surat_pengantar.create', compact('dudi','tahun','siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required|exists:dudi,id',
            'tahun_id' => 'required|exists:tahun_pelaksanaan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'siswa_id' => 'required|array|min:1',
        ]);

        // Validasi bahwa semua siswa yang dipilih memiliki pembimbing
        foreach ($request->siswa_id as $siswaId) {
            $siswa = Siswa::with('pembimbing')->find($siswaId);
            if (!$siswa->pembimbing) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['siswa_id' => 'Siswa ' . $siswa->nama . ' belum memiliki pembimbing. Silakan atur pembimbing terlebih dahulu.']);
            }
        }

        // Cari surat terakhir tahun ini
        $lastSurat = SuratPengantar::whereYear('created_at', date('Y'))
                        ->orderBy('id', 'desc')
                        ->first();

        $lastNumber = 0;
        if ($lastSurat && preg_match('/\/(\d{3})\/' . date('Y') . '$/', $lastSurat->nomor_surat, $matches)) {
            $lastNumber = intval($matches[1]);
        }
        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Buat nomor surat baru
        $nomorSurat = "421.5/HM.III/PRAKERIN/SMKN 1/{$nextNumber}/" . date('Y');

        // Simpan surat
        $surat = SuratPengantar::create([
            'nomor_surat'   => $nomorSurat,
            'lampiran'      => $request->lampiran,
            'perihal'       => $request->perihal,
            'dudi_id'       => $request->dudi_id,
            'tahun_id'      => $request->tahun_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        // Simpan siswa ke pivot beserta nama pembimbing
        foreach ($request->siswa_id as $siswaId) {
            $siswa = Siswa::with('pembimbing')->find($siswaId);
            $pembimbingNama = $siswa->pembimbing ? $siswa->pembimbing->nama : null;
            
            $surat->siswa()->attach($siswaId, [
                'kelas'      => $request->kelas[$siswaId] ?? 'XII',
                'pembimbing' => $pembimbingNama,
            ]);
        }

        return redirect()->route('backend.surat_pengantar.index')
                        ->with('success', 'Surat pengantar berhasil dibuat dengan nomor ' . $nomorSurat);
    }

    public function show(SuratPengantar $surat_pengantar)
    {
        $surat_pengantar->load(['dudi','tahun','siswa.pembimbing','siswa.jurusan']);
        return view('backend.surat_pengantar.show', compact('surat_pengantar'));
    }

    public function destroy(SuratPengantar $surat_pengantar)
    {
        $surat_pengantar->delete();
        return redirect()->route('backend.surat_pengantar.index')->with('success','Surat pengantar berhasil dihapus.');
    }

    public function cetakPDF(SuratPengantar $surat_pengantar)
    {
        $surat_pengantar->load(['dudi','tahun','siswa.jurusan','siswa.pembimbing']);
        $pdf = Pdf::loadView('backend.surat_pengantar.pdf', compact('surat_pengantar'))
                ->setPaper('A4','portrait');

        // Bersihkan karakter ilegal dari nomor surat
        $safeNomorSurat = str_replace(['/', '\\'], '_', $surat_pengantar->nomor_surat);

        return $pdf->download('Surat_Pengantar_'.$safeNomorSurat.'.pdf');
    }

    public function download($id)
    {
        $surat_pengantar = SuratPengantar::with(['dudi','tahun','siswa.jurusan','siswa.pembimbing'])->findOrFail($id);

        $pdf = Pdf::loadView('backend.surat_pengantar.pdf', compact('surat_pengantar'))
                ->setPaper('A4','portrait');

        // Bersihkan karakter ilegal dari nomor surat
        $safeNomorSurat = str_replace(['/', '\\'], '_', $surat_pengantar->nomor_surat);

        return $pdf->download('surat_pengantar_'.$safeNomorSurat.'.pdf');
    }
}
