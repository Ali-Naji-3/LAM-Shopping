<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // إضافة منتج للسلة عبر Ajax
    public function add(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'qty' => 'required|integer|min:1'
    ]);

    $productId = (int) $request->input('product_id');
    $qty = (int) $request->input('qty');

    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['qty'] += $qty;
    } else {
        $product = Product::find($productId);
        $cart[$productId] = [
            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->regular_price ?? $product->price ?? 0,
            'qty'   => $qty,
            'image' => $product->image ?? null,
        ];
    }

    session()->put('cart', $cart);
    session()->save(); // مهم: تأكد من حفظ الجلسة قبل الإرجاع

    $cart_count = collect($cart)->sum('qty');

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'cart_count' => (int) $cart_count
        ]);
    }

    return redirect()->back();
}


    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['qty'];
        });

        return view('frontend.cart', compact('cart', 'subtotal'));
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $cart_count = collect($cart)->sum('qty');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => $cart_count
            ]);
        }

        return redirect()->back();
    }
}
