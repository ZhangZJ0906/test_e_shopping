<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 🔥 加這行


class ProductController extends Controller
{
    //show product
    public function showProduct()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function updateProduct(Request $request, $id): RedirectResponse
    {
        // 驗證輸入資料
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // 'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 🔥 加這行

        ], [
            // 自訂錯誤訊息
            'name.required' => '商品名稱為必填欄位',
            'name.max' => '商品名稱不能超過255個字元',
            'price.required' => '價格為必填欄位',
            'price.numeric' => '價格必須為數字',
            'price.min' => '價格不能小於0',
            'stock.required' => '庫存為必填欄位',
            'stock.integer' => '庫存必須為整數',
            'stock.min' => '庫存不能小於0',
            'image' => '找不到檔案',
            // 'category.max' => '分類不能超過100個字元',
        ]);

        try {
            $products = Product::findOrFail($id);
            if ($request->hasFile('image')) {
                // 刪除舊圖片（如果存在）
                if ($products->image && Storage::disk('public')->exists($products->image)) {
                    Storage::disk('public')->delete($products->image);
                }

                // 儲存新圖片
                $validated['image'] = $request->file('image')->store('products', 'public');
            }


            $products->update($validated);

            return redirect()->route('admin.products')->with('success', '商品「' . $products->name . '」更新成功！');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.products.index')
                ->with('error', '找不到該商品！');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '更新失敗：' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 🔥 加這行
        ], [
            // 自訂錯誤訊息
            'name.required' => '商品名稱為必填欄位',
            'name.max' => '商品名稱不能超過255個字元',
            'price.required' => '價格為必填欄位',
            'price.numeric' => '價格必須為數字',
            'price.min' => '價格不能小於0',
            'stock.required' => '庫存為必填欄位',
            'stock.integer' => '庫存必須為整數',
            'stock.min' => '庫存不能小於0',
            'image' => '圖片只可上傳jpeg,png,jpg,gif',
            // 'category.max' => '分類不能超過100個字元',
        ]);
        try {
            // 🔥 處理檔案上傳
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            Product::create($validated);
            return redirect()->route('admin.products')->with('success', '商品新增成功');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '新增失敗：' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $products = Product::findOrFail($id);
            $products->delete();
            return redirect()->route('admin.products')->with('success', '商品「' . $products->name . '」刪除成功');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '更新失敗：' . $e->getMessage());
        }
    }
}
