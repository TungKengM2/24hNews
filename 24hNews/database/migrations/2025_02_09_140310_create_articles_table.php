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
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('content');
            $table->text('preview_content')->nullable();
            $table->boolean('contains_sensitive_content')->default(false);
            $table->foreignId('author_id')->constrained('users', 'user_id');
            $table->foreignId('category_id')->constrained('categories', 'category_id');
            $table->string('thumbnail_url', 255);
            $table->enum('status', ['draft', 'pending', 'published', 'archived'])->default('draft');
            $table->integer('views')->default(0);
            $table->foreignId('approved_by')->nullable()->constrained('users', 'user_id');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
