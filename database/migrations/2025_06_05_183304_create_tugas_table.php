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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_mata_pelajaran_id')->constrained('guru_mata_pelajaran')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->dateTime('batas_waktu');
            $table->integer('total_nilai')->default(100);
            $table->enum('jenis', ['uraian', 'pilihan_ganda', 'campuran']);
            $table->enum('metode_pengerjaan', ['online', 'upload_file']);
            $table->string('file_tugas')->nullable(); // Untuk menyimpan file tugas yang diupload guru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
