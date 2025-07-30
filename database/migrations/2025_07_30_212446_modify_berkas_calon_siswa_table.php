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
        Schema::table('berkas_calon_siswa', function (Blueprint $table) {
            $table->json('berkas_perlu_perbaikan')->nullable()->after('status_verifikasi');
            $table->text('alasan_penolakan')->nullable()->after('berkas_perlu_perbaikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_calon_siswa', function (Blueprint $table) {
            $table->dropColumn(['berkas_perlu_perbaikan', 'alasan_penolakan']);
        });
    }
};
