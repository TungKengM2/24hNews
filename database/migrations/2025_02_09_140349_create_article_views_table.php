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
        Schema::create('article_views', function (Blueprint $table) {
            $table->id('view_id');
            $table->string('anonymous', 255)->nullable();
            $table->foreignId('article_id')->constrained('articles', 'article_id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id');
            $table->timestamp('viewed_at')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
