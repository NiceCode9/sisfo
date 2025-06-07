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
        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengumpulan_id')->constrained('pengumpulan_tugas')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soal')->onDelete('cascade');
            $table->text('jawaban_teks')->nullable(); // Untuk uraian/esai
            $table->foreignId('id_jawaban')->nullable()->constrained('jawaban'); // Untuk pilihan ganda
            $table->integer('poin_diperoleh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
