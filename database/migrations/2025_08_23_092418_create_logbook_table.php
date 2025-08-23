<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id'); // relasi ke tabel siswa
            $table->date('tanggal');
            $table->text('uraian_tugas');
            $table->text('hasil_output');
            $table->string('dokumentasi')->nullable(); // file foto/pdf
            $table->timestamps();

            $table->foreign('siswa_id')
                  ->references('id')->on('siswa')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};
