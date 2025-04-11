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
        if (!Schema::hasTable('moderation_logs')) {
            Schema::create('moderation_logs', function (Blueprint $table) {
                $table->id('log_id');
                $table->enum('action_type', ['approve', 'reject', 'flag', 'edit', 'delete', 'restore', 'auto_moderate']);
                $table->enum('content_type', ['article', 'comment', 'user', 'category', 'role_upgrade']);
                $table->unsignedBigInteger('content_id');
                $table->unsignedBigInteger('moderator_id')->nullable();
                $table->text('details')->nullable();
                $table->text('before_state')->nullable();
                $table->text('after_state')->nullable();
                $table->enum('severity', ['none', 'low', 'medium', 'high'])->default('none');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moderation_logs');
    }
};
