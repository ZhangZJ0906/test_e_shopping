<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;


class CartItemController extends Controller
{
    /* 
    add cart
    */
    public function addCart(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => '請先登入'], 401);
        }
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $user = auth()->user();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        // 取得商品來檢查庫存
        $product = Product::findOrFail($productId);

        if ($quantity > $product->stock) {
            return response()->json(['status' => 'error', 'message' => '庫存不足'], 422);
        }

        $cartItem = CartItem::firstOrNew([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        $cartItem->quantity += $quantity;

        // ✔ 避免超過庫存
        if ($cartItem->quantity > $product->stock) {
            $cartItem->quantity = $product->stock;
        }

        $cartItem->save();

        return redirect()->back()->with('success', '商品已加入購物車');
        ;
    }

    /*
    show cart
    */

    public function showCart()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
        return view('layouts.app', [
            'view' => 'cart',
            'cartItems' => $cartItems,
        ]);
    }
    /* 
    update cart item

    */

    public function updateCart(Request $request, $id)
    {
        $user = auth()->user();
        $request->validate([
            'change' => 'required|integer|not_in:0',
        ]);
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->with('product')
            ->firstOrFail();
        $newQty = $cartItem->quantity + $request->change;

        if ($newQty < 1) {
            return redirect()->back()->with('error', '數量不能小於 1');
        }

        if ($newQty > $cartItem->product->stock) {
            return redirect()->back()->with('error', '超過庫存上限');
        }

        $cartItem->quantity = $newQty;
        $cartItem->save();

        return redirect()->back()->with('success', '購物車已更新');
    }

    /*
    destory cart
    */

    public function deleteCart(Request $request, $id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cartItem->delete();

        // 若是 AJAX 呼叫就回 JSON
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => '項目已刪除']);
        }

        // 否則就是一般網頁回傳
        return redirect()->back()->with('success', '該物品已刪除');
    }

    /*
        checkout
     */

    public function checkout(Request $request)
    {
        $user = auth()->user();


        $selectedIds = $request->input('selected_items', []);
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', '請先選擇要結帳的商品');
        }
        $cartItems = CartItem::where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', '選擇的商品無效');
        }

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_price' => 0,
        ]);

        $total = 0;

        foreach ($cartItems as $item) {
            $subtotal = $item->product->price * $item->quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);

            // 扣庫存
            $item->product->decrement('stock', $item->quantity);

            $total += $subtotal;
        }

        $order->update(['total_price' => $total]);

        // ❗只刪除有結帳的項目
        CartItem::where('user_id', $user->id)->whereIn('id', $selectedIds)->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => '訂單已建立',
                'order_id' => $order->id
            ]);
        }

        // 若不是 AJAX，就照舊轉頁
        return redirect()->route('orders.show', $order->id)->with('success', '訂單已成立');
    }
}
