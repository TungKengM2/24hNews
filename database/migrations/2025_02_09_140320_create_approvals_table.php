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
            $table->unsignedBigInteger('article_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('type', ['article', 'role_upgrade'])->default('article')->change();
            $table->string('requested_role');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('auto_reviewed')->default(false);
            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('user_id')->on('users')->onDelete('set null');

            $table->timestamps();
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
