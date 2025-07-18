<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    //
    public function showForgotPasswordForm()
    {
        return view('layouts.app', [
            'view' => 'forgot-password',
            'title' => '忘記密碼',
            // 全域變數都會自動有，這裡也能加特殊變數
        ]);
    }
}
