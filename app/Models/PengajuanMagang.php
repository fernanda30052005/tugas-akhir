<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanMagang extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_magang'; // <--- nama tabel fix
    protected $fillable = ['user_id','id_dudi','tahun_id','kuota', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dudi()
    {
        return $this->belongsTo(Dudi::class, 'id_dudi');
    }

    public function tahun()
    {
        return $this->belongsTo(TahunPelaksanaan::class, 'tahun_id');
    }

}
