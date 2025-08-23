<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory;

    protected $table = 'surat_pengantar';

    protected $fillable = [
        'nomor_surat',
        'lampiran',
        'perihal',
        'dudi_id',
        'tahun_id',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public function dudi() {
    return $this->belongsTo(Dudi::class);
    }

    public function tahun() {
        return $this->belongsTo(TahunPelaksanaan::class, 'tahun_id');
    }

    public function siswa() {
        return $this->belongsToMany(Siswa::class, 'surat_pengantar_siswa')
                    ->withPivot('kelas','pembimbing');
    }


}
