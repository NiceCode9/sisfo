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
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_soal')->constrained('soal')->onDelete('cascade');
            $table->text('teks_jawaban');
            $table->boolean('jawaban_benar')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
