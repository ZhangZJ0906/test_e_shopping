<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\CartItem;



class OrderController extends Controller
{
    /*
    show shoping Car user
    */
    public function showOrder()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
        // 進行中訂單（非 completed / cancelled）
        $pendingOrders = Order::where('user_id', $user->id)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->with(['orderItems.product'])
            ->latest()
            ->get();

        // 歷史訂單（只含 completed / cancelled）
        $orders = Order::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->with(['orderItems.product'])
            ->latest()
            ->get();

        return view('layouts.app', [
            'view' => 'cart', // 這是你 include 的畫面
            'cartItems' => $cartItems,
            'pendingOrders' => $pendingOrders,
            'orders' => $orders,
        ]);
    }

    /*
    show shoping Car admin
    */
    public function showAdminOrder()
    {
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isBoss() && !$user->isEngineer()) {
            return redirect()->route('home');
        }
        $completedOrders = Order::with('user')->whereIn('status', ['completed', 'cancelled'])->paginate(4, ['*'], 'completed_page');
        $pendingOrders = Order::with('user')->whereIn('status', ['pending', 'processing', 'shipped'])->paginate(4, ['*'], 'pending_page');
        // $orderItem = $orders->orderItems;
        return view('backend.totalOrder', compact('completedOrders', 'pendingOrders'));
    }

    public function updateAdminOrder(Request $request ,$id)
    {
        // dd($request->status, $id);

        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isBoss() && !$user->isEngineer()) {
            return redirect()->route('home');
        }
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        return redirect()->route('admin.total-order')->with('success', '更新成功');
    }


}
