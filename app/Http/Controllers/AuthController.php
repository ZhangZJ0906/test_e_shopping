<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // welcome
    public function showWelcome()
    {
        return view('layouts.app', [
            'view' => 'welcome',
            'title' => '主頁',
            // 全域變數都會自動有，這裡也能加特殊變數
        ]);
    }

    public function showBackend()
    {
        return view('backend.index',);
    }
    //login 
    public function login(Request $request)
    {
        $check = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($check)) {
            $request->session()->regenerate();

            return redirect()->route('home');
        };
        // 登入失敗
        return back()->withErrors([
            'email' => '帳號或密碼錯誤',
        ]);
    }


    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('layouts.app', [
            'view' => 'login',
            'title' => '登入',
            // 全域變數都會自動有，這裡也能加特殊變數
        ]);
    }
    public function showRegisterForm()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('layouts.app', [
            'view' => 'register',
            'title' => '註冊',
            // 全域變數都會自動有，這裡也能加特殊變數
        ]);
    }
    public function register(Request $request)
    {
        // 驗證失敗會自動重定向回表單並帶上錯誤訊息
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'gender' => 'required',
            'phone' => 'required | numeric',
        ], [
            // 自訂錯誤訊息
            'name.required' => '姓名為必填欄位',
            'email.required' => '電子郵件為必填欄位',
            'email.email' => '請輸入有效的電子郵件格式',
            'email.unique' => '此電子郵件已被註冊',
            'password.required' => '密碼為必填欄位',
            'password.min' => '密碼至少需要8個字元',
            'gender.required' => '性別為必填欄位',
            'phone.required' => '手機為必填欄位',
            // 'password.confirmed' => '密碼確認不符',
        ]);
        // dd($validated);

        try {
            // 建立使用者
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
            ]);
        // dd($user);

            // 自動登入
            Auth::login($user);

            return redirect()->route('home')->with('success', '註冊成功！歡迎加入！');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => '註冊過程中發生錯誤，請稍後再試。']);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', '您已成功登出！');
    }
}
