<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPelaksanaan extends Model
{
    use HasFactory;

    protected $table = 'tahun_pelaksanaan';

    protected $fillable = [
        'tahun_pelaksanaan',
    ];
}
