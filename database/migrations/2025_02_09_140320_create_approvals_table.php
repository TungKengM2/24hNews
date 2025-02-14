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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id('approval_id');
            $table->foreignId('article_id')->constrained('articles', 'article_id');
            $table->foreignId('approved_by')->constrained('users', 'user_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('auto_reviewed')->default(false);
            $table->text('remarks');
            $table->timestamp('created_at')->useCurrent();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
