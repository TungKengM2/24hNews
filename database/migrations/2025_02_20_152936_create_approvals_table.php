<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    public function up()
    {
        // approvals su ly ca: article va upgrade user
        Schema::create('approvals', function (Blueprint $table) {
            $table->bigIncrements('approval_id');
            $table->unsignedBigInteger('article_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('type', ['article', 'role_upgrade'])
                ->default('article');
            $table->string('requested_role')
                ->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->boolean('auto_reviewed')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Foreign keys
            $table->foreign('article_id')
                ->references('article_id')
                ->on('articles')
                ->onDelete('set null');
            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('approved_by')
                ->references('user_id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}
