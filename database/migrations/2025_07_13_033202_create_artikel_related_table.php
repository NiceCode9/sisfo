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
        Schema::create('artikel_related', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('artikel')->onDelete('cascade');
            $table->foreignId('related_article_id')->constrained('artikel')->onDelete('cascade');
            $table->integer('relevance_score')->default(0);
            $table->timestamps();

            $table->unique(['article_id', 'related_article_id']);
            $table->index(['article_id', 'relevance_score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel_related');
    }
};
