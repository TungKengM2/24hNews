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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 50)->unique();
            $table->string('phone', 15);
            $table->string('image', 255)->nullable();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable(); // Xác nhận email
            $table->string('password', 255);
            $table->rememberToken(); // Token nhớ đăng nhập
            $table->foreignId('role_id')->constrained('roles', 'role_id');
            $table->boolean('is_promoted')->default(false);
            $table->integer('violation_count')->default(0);
            $table->timestamp('banned_until')->nullable();
            $table->timestamps(); // Tự động thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
