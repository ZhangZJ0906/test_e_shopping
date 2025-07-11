
<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// 首頁
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('首頁', route('home'));
});

// 登入
Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('登入', route('login'));
});

// 註冊
Breadcrumbs::for('register', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('註冊', route('register'));
});

// 後台首頁
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('後台首頁', route('admin.dashboard'));
});

// 商品管理
Breadcrumbs::for('admin.products', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('商品管理', route('admin.products'));
});

// 新增商品
Breadcrumbs::for('admin.products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.products');
    $trail->push('新增商品', route('admin.products.create'));
});

// 編輯商品（針對您的 PUT 路由）
Breadcrumbs::for('admin.products.update', function (BreadcrumbTrail $trail, $productId) {
    $trail->parent('admin.products');
    $trail->push('編輯商品', route('admin.products.update', $productId));
});

Breadcrumbs::for('admin.changeStatus', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('更換權限', route('admin.changeStatus'));
});
