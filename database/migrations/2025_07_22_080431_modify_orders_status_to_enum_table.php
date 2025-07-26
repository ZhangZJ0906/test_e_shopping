<?php
// database/migrations/xxxx_xx_xx_modify_orders_status_to_enum_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 先刪除現有的 status 欄位
            $table->dropColumn('status');
        });

        Schema::table('orders', function (Blueprint $table) {
            // 新增 enum status 欄位
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])
                ->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 回復時刪除 enum 欄位
            $table->dropColumn('status');
        });

    }
};