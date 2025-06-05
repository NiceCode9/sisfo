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
        Schema::create('guru_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['guru_id', 'mata_pelajaran_id'], 'guru_mapel_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mata_pelajaran');
    }
};
