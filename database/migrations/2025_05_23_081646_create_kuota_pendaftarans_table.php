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
        Schema::create('kuota_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->string('jalur_pendaftaran'); // Contoh: Zonasi, Prestasi, Afirmasi, dll
            $table->integer('kuota');
            $table->integer('terisi')->default(0);
            $table->text('keterangan')->nullable(); // Keterangan tambahan tentang kuota
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuota_pendaftaran');
    }
};
