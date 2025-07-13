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
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->text('featured_image_alt')->nullable();
            $table->text('featured_image_caption')->nullable();

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->json('og_data')->nullable(); // Open Graph data
            $table->json('schema_data')->nullable(); // JSON-LD schema

            // Content Fields
            $table->foreignId('category_id')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->integer('reading_time')->nullable(); // in minutes
            $table->integer('word_count')->default(0);

            // Status & Publishing
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_breaking')->default(false);
            $table->timestamp('published_at')->nullable();

            // Analytics & Performance
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->integer('comments_count')->default(0);

            // SEO Performance
            $table->decimal('seo_score', 3, 1)->nullable(); // 0.0 to 10.0
            $table->json('seo_analysis')->nullable(); // SEO analysis results

            $table->timestamps();

            // Indexes for SEO & Performance
            $table->index(['slug', 'status']);
            $table->index(['category_id', 'status', 'published_at']);
            $table->index(['author_id', 'status', 'published_at']);
            $table->index(['status', 'published_at']);
            $table->index(['status', 'is_featured', 'published_at']);
            $table->index(['status', 'is_breaking', 'published_at']);
            $table->index('views_count');
            $table->fullText(['title', 'excerpt', 'content']); // For search functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
