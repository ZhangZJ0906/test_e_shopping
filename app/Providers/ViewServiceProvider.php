<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 全局共享基本資訊
        View::share([
            'siteName' => '張董商城',
            'currentYear' => date('Y'),
            'companyName' => '張董企業有限公司',
            "name" => 'Home'
        ]);

        // 為所有視圖提供認證資訊 - 注意這裡的語法
        View::composer('*', function ($view) {
            $view->with([
                'currentUser' => Auth::user(),
                'isLoggedIn' => Auth::check(),
            ]);
            $route = Route::current();
            $routeName = $route ? $route->getName() : null;
            // 根據不同 routeName 給不同 name 前端
            $titleMap = [
                'home' => '首頁',
                'register' => '註冊',
                'login' => '登入',
                'welcome' => '歡迎',
                'profile' => '個人資料',
            ];
            $view->with([
                'siteName'    => '張董商城',
                'currentYear' => date('Y'),
                'companyName' => '張董企業有限公司',
                'name'        => $titleMap[$routeName] ?? ucfirst($routeName ?? '首頁'),
            ]);
        });

        // 為navbar提供資料 frontend
        View::composer('components.navbar', function ($view) {
            $role = $this->getrole();

            if ($role == 'member') {
                $view->with([
                    'navigationItems' => $this->getNavigationItems(),
                    'userMenuItems' => $this->getUserMenuItems(),
                    // 'adminMenuItems' => $this->getAdminMenuItems(),
                ]);
            } else {
                $view->with([
                    'navigationItems' => $this->getNavigationItems(),
                    'userMenuItems' => $this->getUserMenuItems(),
                    'adminMenuItems' => $this->getAdminMenuItems(),
                ]);
            }
        });

        // 為footer提供資料  frontend
        View::composer('components.footer', function ($view) {
            $view->with([
                'footerLinks' => $this->getFooterLinks(),
                'socialMediaLinks' => $this->getSocialMediaLinks(),
            ]);
        });

        // 為主布局提供meta資訊 frontend
        View::composer('layouts.app', function ($view) {
            $view->with([
                'metaDescription' => '張董商城 - 您的購物首選',
                'metaKeywords' => '商城,購物,張董',
                'canonicalUrl' => request()->url(),
            ]);
        });

        // 為主布局提供meta資訊 backend 
        View::composer('layouts.backend', function ($view) {
            $view->with([
                'metaDescription' => '張董商城 - 您的購物首選',
                'metaKeywords' => '商城,購物,張董',
                'canonicalUrl' => request()->url(),
            ]);
        });
    }
    /**
     * 取得登入人身分
     */
    protected function getrole()
    {
        if (Auth::check()) {
            $user = Auth::user()->role;

            // dd($user);
            return $user;
        }
        return null;
    }
    /**
     * 取得導航項目 普通人
     */
    protected function getNavigationItems(): array
    {
        return [
            [
                'name' => 'Home',
                'route' => 'home',
                'active' => request()->routeIs('home')
            ],
            // [
            //     'name' => '所有商品',
            //     'route' => 'products.index', // 記得要有這個路由
            //     'active' => request()->routeIs('products.*')
            // ],
        ];
    }

    /**
     * 取得用戶選單項目 會員
     */
    protected function getUserMenuItems(): array
    {
        if (Auth::check()) {
            return [
                [
                    'name' => '個人資料',
                    'route' => 'profile',
                    'active' => request()->routeIs('profile')

                ],
                // [
                //     'name' => '訂單記錄',
                //     'route' => 'orders.index',
                // ],
            ];
        }

        return [];
    }

    // 有權限的人 管理員或是工程師 或是boss 
    protected function getAdminMenuItems(): array
    {
        if (Auth::check()) {
            return [
                [
                    'name' => '後台',
                    'route' => 'admin.dashboard', // 這裡填 web.php 路由命名
                    'active' => request()->routeIs('dashboard')

                ],
            ];
        }
        return [];
    }
    /**
     * 取得頁尾連結
     */
    protected function getFooterLinks(): array
    {
        return [
            '關於我們' => '#', // 暫時用 # 代替，避免路由不存在的錯誤
            '聯絡我們' => '#',
            '服務條款' => '#',
            '隱私政策' => '#',
        ];
    }

    /**
     * 取得社群媒體連結
     */
    protected function getSocialMediaLinks(): array
    {
        return [
            'facebook' => 'https://facebook.com/',
            'instagram' => 'https://instagram.com/',
            'twitter' => 'https://x.com/',
        ];
    }
}
