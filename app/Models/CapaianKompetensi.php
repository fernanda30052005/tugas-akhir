<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapaianKompetensi extends Model
{
    use HasFactory;

    protected $table = 'capaian_kompetensi';

    protected $fillable = [
        'jurusan_id',
        'nama_kompetensi',
        'status',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
