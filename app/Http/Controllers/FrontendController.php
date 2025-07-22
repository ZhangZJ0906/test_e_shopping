<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FrontendController extends Controller
{
    /*
    show frontend single product
    */

    public function showFrontendProduct($id)
    {
        $product = Product::find($id);

        return view('layouts.app', [
            'view' => 'product',
            'title' => $product->name,
            'product' => $product
            // 全域變數都會自動有，這裡也能加特殊變數
        ]);
    }
}
