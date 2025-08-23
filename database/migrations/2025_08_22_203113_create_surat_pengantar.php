<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_pengantar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('lampiran')->nullable();
            $table->string('perihal')->default('Pengantar Prakerin');
            $table->foreignId('dudi_id')->constrained('dudi')->onDelete('cascade');
            $table->foreignId('tahun_id')->constrained('tahun_pelaksanaan')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
        });

        // Tabel pivot surat_pengantar_siswa
        Schema::create('surat_pengantar_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_pengantar_id')->constrained('surat_pengantar')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('kelas');
            $table->string('pembimbing')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar_siswa');
        Schema::dropIfExists('surat_pengantar');
    }
};
