<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update data yang sudah ada dengan format yang salah
        DB::table('pembimbing')
            ->where('jenis_kelamin', 'L')
            ->update(['jenis_kelamin' => 'Laki-laki']);
            
        DB::table('pembimbing')
            ->where('jenis_kelamin', 'P')
            ->update(['jenis_kelamin' => 'Perempuan']);
    }

    public function down(): void
    {
        // Tidak perlu rollback karena ini adalah data correction
    }
};
