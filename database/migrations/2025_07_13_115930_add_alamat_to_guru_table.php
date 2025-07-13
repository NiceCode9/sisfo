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
        Schema::table('guru', function (Blueprint $table) {
            $table->text('alamat')->nullable();
            $table->string('gelar')->nullable();
            $table->string('telp')->nullable();
            $table->string('foto_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn('alamat');
            $table->dropColumn('gelar');
            $table->dropColumn('telp');
            $table->dropColumn('foto_path');
        });
    }
};
