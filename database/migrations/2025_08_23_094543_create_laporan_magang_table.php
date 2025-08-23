<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('laporan_magang', function (Blueprint $table) {
        $table->id();
        $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
        $table->string('judul_laporan');
        $table->string('file_laporan'); // path PDF
        $table->date('tanggal_upload');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('laporan_magang');
}
};
