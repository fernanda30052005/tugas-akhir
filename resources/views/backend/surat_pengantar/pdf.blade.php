<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar Prakerin</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; line-height: 1.5; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .school-name { font-size: 16pt; font-weight: bold; margin-bottom: 5px; }
        .school-address { font-size: 11pt; margin-bottom: 5px; }
        .letter-info { margin-bottom: 20px; }
        .letter-info table { width: 100%; border-collapse: collapse; }
        .letter-info td { padding: 2px 10px; vertical-align: top; }
        .letter-info td:first-child { width: 80px; }
        .recipient { margin-bottom: 20px; }
        .content { text-align: justify; margin-bottom: 20px; }
        .student-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .student-table th, .student-table td { border: 1px solid #000; padding: 8px; text-align: center; }
        .student-table th { background-color: #f0f0f0; font-weight: bold; }
        .signature { text-align: right; margin-top: 30px; }
        .signature-info { margin-bottom: 5px; }
        .contact-info { position: fixed; bottom: 20px; left: 20px; font-size: 10pt; }
    </style>
</head>
<body>
    <!-- Kop Sekolah -->
    <div class="header">
        <div class="school-name">SMKN 1 PANGKALAN KERINCI</div>
        <div class="school-address">Jl. Raya Pangkalan Kerinci No. 1, Pangkalan Kerinci, Pelalawan, Riau</div>
        <div class="school-address">Telp: (0761) 5902664 | Email: smkn1pk@yahoo.co.id</div>
    </div>

    <!-- Informasi Surat -->
    <div class="letter-info">
        <table>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $surat_pengantar->nomor_surat ?? '421.5/HM.III/PRAKERIN/SMKN 1/' }}</td>
            </tr>
            <tr>
                <td>Lamp</td>
                <td>:</td>
                <td>{{ $surat_pengantar->lampiran ?? '-' }}</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td>{{ $surat_pengantar->perihal ?? 'Pengantar Prakerin' }}</td>
            </tr>
        </table>
    </div>

    <!-- Tujuan -->
    <div class="recipient">
        <div>Kepada Yth.</div>
        <div>Bapak/Ibu pimpinan {{ $surat_pengantar->dudi?->nama ?? '-' }}</div>
        <div>Di</div>
        <div style="margin-left: 20px;">{{ $surat_pengantar->dudi?->alamat ?? 'Pangkalan Kerinci' }}</div>
    </div>

    <!-- Isi Surat -->
    <div class="content">
        <p>Dengan hormat,</p>
        <p style="text-indent: 20px;">
            Sehubungan dengan pelaksanaan prakerin siswa SMKN 1 Pangkalan Kerinci, maka dengan ini kami mengirimkan siswa untuk melaksanakan prakerin mulai tanggal 
            <strong>{{ $surat_pengantar->tanggal_mulai ?? '-' }}</strong> s/d 
            <strong>{{ $surat_pengantar->tanggal_selesai ?? '-' }}</strong> 
            pada jurusan <strong>{{ $surat_pengantar->siswa->first()?->jurusan?->jurusan ?? '-' }}</strong>.
        </p>
        <p style="text-indent: 20px;">
            Adapun nama siswa yang akan melaksanakan prakerin adalah sebagai berikut:
        </p>
    </div>

    <!-- Daftar Siswa -->
    <table class="student-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA SISWA</th>
                <th>KELAS</th>
                <th>JURUSAN</th>
                <th>PEMBIMBING</th>
            </tr>
        </thead>
        <tbody>
            @forelse($surat_pengantar->siswa as $i => $s)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ strtoupper($s->nama) }}</td>
                    <td>{{ $s->pivot->kelas ?? '-' }}</td>
                    <td>{{ $s->jurusan?->jurusan ?? '-' }}</td>
                    <td>{{ $s->pivot->pembimbing ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada siswa terdata</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Penutup -->
    <div class="content">
        <p style="text-indent: 20px;">
            Demikian atas kerjasamanya kami ucapkan terima kasih.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <div class="signature-info">Pangkalan Kerinci, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
        <div class="signature-info">An. Kepala</div>
        <div class="signature-info">WAKA BID. HUMAS</div>
        <div style="margin-top: 50px;">
            <div class="signature-info"><strong>Abdul Rasyid. R, S. Pd</strong></div>
            <div class="signature-info">NIP. 198007052008011022</div>
        </div>
    </div>

    <!-- Kontak -->
    <div class="contact-info">
        <div>NO. TEL: HUMAS: 0761-5902664</div>
        <div>TU : 0761-5902624</div>
    </div>
</body>
</html>
