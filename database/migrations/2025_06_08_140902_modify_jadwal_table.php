<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            // Ganti guru_mata_pelajaran_id dengan guru_kelas_id
            $table->dropForeign(['guru_mata_pelajaran_id']);
            $table->dropForeign(['kelas_id']); // akan di-recreate via guru_kelas

            $table->dropColumn(['guru_mata_pelajaran_id', 'kelas_id']);

            $table->foreignId('guru_kelas_id')->after('id')
                ->constrained('guru_kelas')->onDelete('cascade');

            // Tambah tahun ajaran untuk jadwal
            $table->foreignId('tahun_ajaran_id')->after('guru_kelas_id')
                ->constrained('tahun_ajaran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropForeign(['guru_kelas_id']);
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn(['guru_kelas_id', 'tahun_ajaran_id']);

            $table->foreignId('guru_mata_pelajaran_id')->constrained('guru_mata_pelajaran')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
        });
    }
};
