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
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique();
            $table->string('bio')->nullable();
            $table->string('fb')->nullable();
            $table->string('ig')->nullable();
            $table->string('x')->nullable();
            $table->string('li')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('bio');
            $table->dropColumn('fb');
            $table->dropColumn('ig');
            $table->dropColumn('x');
            $table->dropColumn('li');
            $table->dropColumn('is_active');
        });
    }
};
