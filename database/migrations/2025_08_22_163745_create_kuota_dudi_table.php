<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuota_dudi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_dudi')->constrained('dudi')->onDelete('cascade');
            $table->foreignId('tahun_id')->constrained('tahun_pelaksanaan')->onDelete('cascade'); // relasi ke tahun pelaksanaan
            $table->integer('kuota')->default(0);
            $table->timestamps();

            $table->unique(['id_dudi', 'tahun_id']); // agar satu DUDI per tahun hanya bisa 1 kuota
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('kuota_dudi');
    }
};
