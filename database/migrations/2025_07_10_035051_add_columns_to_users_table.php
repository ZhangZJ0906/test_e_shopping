<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            // 🔥 新增 role 欄位
            $table->enum('role', ['admin', 'boss', 'engineer', 'guest', 'member'])
                ->default('member')
                ->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // 🔥 回滾時刪除 role 欄位
            $table->dropColumn('role');
        });
    }
};
