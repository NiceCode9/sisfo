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
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_pendaftaran_id')->nullable()->constrained('jalur_pendaftaran')->onDelete('set null');
            $table->string('no_pendaftaran')->unique(); // Format: PPDB-YYYY-XXXX
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin'); // L/P
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('email')->unique();
            $table->string('asal_sekolah');
            $table->string('nama_orang_tua');
            $table->string('pekerjaan_orang_tua');
            $table->string('no_hp_orang_tua');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->string('status_pendaftaran')->default('menunggu'); // menunggu, diterima, ditolak, daftar_ulang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};
