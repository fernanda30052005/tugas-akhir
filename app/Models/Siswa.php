<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa'; 

    protected $fillable = [
        'user_id',
        'nama',
        'nis',
        'jurusan_id',
        'jenis_kelamin',
        'no_hp',
        'pembimbing_id', // ✅ tambahkan ini
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(\App\Models\Jurusan::class, 'jurusan_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(\App\Models\Pembimbing::class, 'pembimbing_id');
    }
}
