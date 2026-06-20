<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('post_id')->nullable()->constrained()->cascadeOnDelete()->after('status');
            $table->foreignId('comment_id')->nullable()->constrained()->cascadeOnDelete()->after('post_id');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropForeign(['comment_id']);
            $table->dropColumn(['post_id', 'comment_id']);
        });
    }
};
