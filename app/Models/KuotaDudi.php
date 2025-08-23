<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaDudi extends Model
{
    use HasFactory;
    protected $table = 'kuota_dudi';
    protected $fillable = ['id_dudi', 'tahun_id', 'kuota'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Validasi tambahan untuk mencegah duplikasi
            $exists = self::where('id_dudi', $model->id_dudi)
                        ->where('tahun_id', $model->tahun_id)
                        ->exists();
            
            if ($exists) {
                throw new \Exception('Kombinasi DUDI dan Tahun Pelaksanaan sudah ada dalam sistem.');
            }
        });
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
