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
        Schema::create('artikel_analis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('artikel')->onDelete('cascade');
            $table->date('date');
            $table->integer('views')->default(0);
            $table->integer('unique_views')->default(0);
            $table->integer('bounce_rate')->default(0);
            $table->integer('avg_time_on_page')->default(0); // in seconds
            $table->json('referrer_data')->nullable();
            $table->json('search_keywords')->nullable();
            $table->timestamps();

            $table->unique(['article_id', 'date']);
            $table->index(['article_id', 'date']);
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel_analis');
    }
};
