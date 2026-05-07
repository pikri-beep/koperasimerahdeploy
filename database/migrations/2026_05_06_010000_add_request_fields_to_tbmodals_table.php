<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbmodals', function (Blueprint $table) {
            if (!Schema::hasColumn('tbmodals', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->after('id');
            }
            if (!Schema::hasColumn('tbmodals', 'status')) {
                $table->string('status')->default('approved')->after('user_id');
            }
            if (!Schema::hasColumn('tbmodals', 'is_request')) {
                $table->boolean('is_request')->default(false)->after('status');
            }
            if (!Schema::hasColumn('tbmodals', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('is_request');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbmodals', function (Blueprint $table) {
            if (Schema::hasColumn('tbmodals', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
            if (Schema::hasColumn('tbmodals', 'is_request')) {
                $table->dropColumn('is_request');
            }
            if (Schema::hasColumn('tbmodals', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('tbmodals', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
