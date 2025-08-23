<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMagang extends Model
{
    use HasFactory;

    protected $table = 'laporan_magang';

    protected $fillable = [
        'siswa_id',
        'judul_laporan',
        'file_laporan',
        'tanggal_upload',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
