<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 關閉外鍵檢查
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 清空資料
        DB::table('users')->truncate();

        // 開啟外鍵檢查
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 建立用戶
        DB::table('users')->insert([
            [
                'name' => '管理員',
                'email' => 'admin@shop.com',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '測試用戶',
                'email' => 'test@shop.com',
                'password' => Hash::make('test123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


        // 如果有商品表  
        if (Schema::hasTable('products')) {
            DB::table('products')->insert([
                [
                    'name' => 'iPhone 15',
                    'price' => 35900,
                    'stock' => 50,
                    'description' => '最新iPhone',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'MacBook Air',
                    'price' => 36900,
                    'stock' => 20,
                    'description' => '輕薄筆電',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }

        $this->command->info('✅ 測試資料建立完成！');
        $this->command->info('👤 管理員：admin@shop.com / admin123');
        $this->command->info('👤 用戶：test@shop.com / test123');
    }
}
