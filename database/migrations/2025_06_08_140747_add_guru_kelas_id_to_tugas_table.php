<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Tambah foreign key ke guru_kelas
            $table->foreignId('guru_kelas_id')->after('guru_mata_pelajaran_id')
                ->constrained('guru_kelas')->onDelete('cascade');

            // Hapus constraint lama
            $table->dropForeign(['guru_mata_pelajaran_id']);
            $table->dropColumn('guru_mata_pelajaran_id');
        });
    }

    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropForeign(['guru_kelas_id']);
            $table->dropColumn('guru_kelas_id');
            $table->foreignId('guru_mata_pelajaran_id')->constrained('guru_mata_pelajaran')->onDelete('cascade');
        });
    }
};
