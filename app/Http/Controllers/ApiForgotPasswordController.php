<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiForgotPasswordController extends Controller
{
    /*
    確認email
    */

    public function checkEmail(Request $request)
    {
        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => '查無此信箱'], 404);
        }
        return response()->json(['status' => 'success', 'email' => $user->email]);
    }

    /*
    重設密碼
    */
    public function resetPassword(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            $validate = $request->validate([
                'password' => 'required|string|min:8',
                'email' => 'required|email',
            ], [
                'password.required' => '密碼為必填欄位',
                'password.min' => '密碼至少需要8個字元',
                'email.required' => '電子郵件為必填欄位',
            ]);
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['status' => 'success', 'message' => '重設密碼成功']);
            // return response()->json([
            //     'validate' => $validate,
            //     'user' => $user,
            //     'password' => $request->password
            // ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => '重設密碼失敗'], 500);
        }
    }
}
