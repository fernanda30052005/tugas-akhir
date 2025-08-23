<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user yang mengusulkan
            $table->foreignId('id_dudi')->constrained('dudi')->onDelete('cascade');
            $table->foreignId('tahun_id')->constrained('tahun_pelaksanaan')->onDelete('cascade');
            $table->integer('kuota'); // kuota saat dibuat dari kuota_dudi
            $table->enum('status',['Pending','Diterima','Ditolak'])->default('Pending');
            $table->timestamps();

            $table->unique(['user_id','id_dudi','tahun_id']); // user hanya bisa mengusulkan 1x per DUDI + Tahun
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_magang');
    }
};
