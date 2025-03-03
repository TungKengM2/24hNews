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
            $table->string('phone', 15)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable(); // Xác nhận email
            $table->string('password', 255)->nullable(); // Có thể null nếu đăng nhập bằng Google/Facebook
            $table->rememberToken(); // Token nhớ đăng nhập

            // Khóa ngoại cho vai trò, đặt giá trị mặc định
            $table->unsignedBigInteger('role_id')->default(4); // 2 là ID mặc định của User
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');

            $table->boolean('is_promoted')->default(false);
            $table->integer('violation_count')->default(0);
            $table->timestamp('banned_until')->nullable();

            // Đăng nhập Google/Facebook
            $table->string('provider')->nullable(); // google, facebook
            $table->string('provider_id')->nullable()->unique(); // ID tài khoản từ Google/Facebook

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
