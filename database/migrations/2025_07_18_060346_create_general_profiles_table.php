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
        Schema::create('general_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('nama_kepsek')->nullable();
            $table->string('alamat')->nullable();
            $table->text('telp')->nullable();
            $table->text('email')->nullable();
            $table->text('map')->nullable();
            $table->json('sosmed')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->year('tahun_berdiri')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_profiles');
    }
};
