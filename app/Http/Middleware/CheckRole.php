<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 檢查是否登入
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', '請先登入');
        }

        // 檢查角色
        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            // 根據當前用戶角色重定向到適當頁面
            switch ($userRole) {
                case 'admin':
                case 'boss':
                    return redirect()->route('admin.dashboard')->with('error', '沒有權限存取此頁面');
                case 'engineer':
                case 'member':
                    return redirect()->route('home')->with('error', '沒有權限存取此頁面');
                default:
                    return redirect()->route('home')->with('error', '沒有權限存取此頁面');
            }
        }
        return $next($request);
    }
}
