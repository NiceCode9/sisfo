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
        Schema::create('sitemaps', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->enum('type', ['article', 'category', 'tag', 'author', 'page']);
            $table->foreignId('reference_id')->nullable(); // ID dari table terkait
            $table->string('changefreq')->default('daily');
            $table->decimal('priority', 2, 1)->default(0.8);
            $table->timestamp('last_modified');
            $table->timestamps();

            $table->unique(['url', 'type']);
            $table->index(['type', 'last_modified']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitemaps');
    }
};
