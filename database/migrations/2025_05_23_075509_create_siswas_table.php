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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_siswa_id')->constrained('calon_siswa')->onDelete('cascade');
            $table->string('nis')->unique();
            $table->string('nisn')->nullable()->unique();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade'); // Tahun ajaran saat siswa diterima
            $table->string('kelas_awal')->default('7'); // Kelas 7 untuk SMP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
