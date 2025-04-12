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
        Schema::table('article_edit_requests', function (Blueprint $table) {
            $table->string('field_to_edit')->nullable()->after('reason');
            $table->timestamp('request_expires_at')->nullable()->after('processed_at');
            $table->timestamp('edit_expires_at')->nullable()->after('request_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_edit_requests', function (Blueprint $table) {
            $table->dropColumn('field_to_edit');
            $table->dropColumn('request_expires_at');
            $table->dropColumn('edit_expires_at');
        });
    }
};
