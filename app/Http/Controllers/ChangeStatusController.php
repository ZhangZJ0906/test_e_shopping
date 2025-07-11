<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChangeStatusController extends Controller
{
    //
    public function showChangeStatus()
    {

        $users = User::all();
        // dd($users);
        return view('backend.changeStatus', compact('users'));
    }

    public function updateChangeStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'role' => 'required|string|in:admin,boss,engineer,member,guest',  // 🔥 加入 in 驗證
            ], [
                'role.required' => '角色為必填欄位',
                'role.in' => '請選擇有效的角色',
            ]);
            $user = User::findOrFail($id);
            if ($request->role == $user->role) {
                return redirect()->back()->with('error', '請選擇不同的角色');
            }
            $oldRole = $user->role;
            $user->role = $request->role;
            $user->save();
            return redirect()->route('admin.changeStatus')->with('success', '更新成功');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', '找不到該用戶！');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '更新失敗：' . $e->getMessage());
        }
    }
}
