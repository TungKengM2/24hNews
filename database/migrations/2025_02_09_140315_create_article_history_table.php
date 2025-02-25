<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_history', function (Blueprint $table) {
            $table->id('history_id');
            $table->foreignId('article_id')
                ->constrained('articles', 'article_id')
                ->onDelete('cascade'); // Xóa bài viết sẽ xóa lịch sử liên quan

            $table->text('content');

            $table->foreignId('edited_by')
                ->nullable() // Cho phép null nếu người dùng bị xóa
                ->constrained('users', 'user_id')
                ->onDelete('set null'); // Nếu user bị xóa, giữ lại lịch sử và đặt edited_by = null

            $table->timestamp('edited_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_history');
    }
};
