<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Gocommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '一鍵開發環境初始化命令';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('');
        $this->info('🚀 開始執行 Laravel Go 命令...');
        $this->info('');

        // 清除快取
        $this->info('🧹 清除快取中...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');

        // 執行資料庫遷移
        $this->info('📊 執行資料庫遷移...');
        $this->call('migrate');

        // 填充資料（如果需要的話）
        if ($this->confirm('是否要執行資料填充 (seeder)？', false)) {
            $this->call('db:seed');
        }

        // 生成應用程式金鑰（如果還沒有的話）
        if (empty(config('app.key'))) {
            $this->info('🔐 生成應用程式金鑰...');
            $this->call('key:generate');
        }

        // 建立儲存連結
        if (!file_exists(public_path('storage'))) {
            $this->info('🔗 建立儲存連結...');
            $this->call('storage:link');
        }

        // $this->info('');
        $this->info('✅ 所有任務執行完成！');
        $this->info('🌐 正在執行 php artisan serve 啟動開發服務器');
        // $this->info('');
        $this->call('serve');

        return Command::SUCCESS;
    }
}