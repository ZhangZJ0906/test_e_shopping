<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProFileController extends Controller
{
    //
    public function showProfile()
    {
        // $user = Auth::user();

        // dd($user);
        return view(
            'layouts.app',
            [
                'view' => 'profile',
                'title' => '個人資料'
            ],
            // compact('user')
        );
    }
    /**
     * 更新會員個人資料
     */
    public function updateProfile(Request $request, $id)
    {
        try {
            if (Auth::id() != $id) {
                abort(403, '你無權限編輯他人資料');
            }
            $user = User::findOrFail($id);
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'gender' => 'required',
            ], [
                'name.required' => '姓名為必填欄位',
                'email.required' => '電子郵件為必填欄位',
                'email.email' => '請輸入有效的電子郵件格式',
                'phone.required' => '手機為必填欄位',
                'gender.required' => '性別為必填欄位',
            ]);

            $user->update($validated);
            return redirect()->back()->with('success', '更新成功');
        } catch (\Exception $e) {
            return  redirect()->back()
                ->withInput()
                ->with('error', '更新失敗：' . $e->getMessage());
        }
    }


    public function editPassWordProfile(Request $request, $id)
    {
        try {
            //code...
            if (Auth::id() != $id) {
                abort(403, '你無權限編輯他人資料');
            }

            $user = User::findOrFail($id);
            $validated = $request->validate([
                'password' => 'required|string|min:8',
            ], [
                'password.required' => '密碼為必填欄位',
                'password.min' => '密碼至少需要8個字元',
            ]);

            $user->password = Hash::make($validated['password']);
            $user->save();
            return redirect()->back()->with('success', '更新密碼成功');
        } catch (\Exception $e) {
            return  redirect()->back()
                ->withInput()
                ->with('error', '更新密碼失敗：' . $e->getMessage());
        }
    }
}
