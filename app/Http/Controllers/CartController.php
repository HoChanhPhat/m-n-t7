<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // XEM GIỎ HÀNG
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_column($cart, 'subtotal'));

        return view('cart.index', compact('cart', 'total'));
    }

    // THÊM SẢN PHẨM VÀO GIỎ
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Lấy giỏ hiện tại
        $cart = session()->get('cart', []);

        // Lấy số lượng từ JSON fetch()
        $quantity = intval($request->input('quantity', 1));
        if ($quantity < 1) $quantity = 1;

        // Nếu đã tồn tại → tăng số lượng
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } 
        else {
            $cart[$id] = [
                'name'      => $product->name,
                'price'     => $product->price,
                'image'     => $product->image,
                'quantity'  => $quantity,
            ];
        }

        // Cập nhật subtotal
        $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];

        // Lưu vào session
        session()->put('cart', $cart);

        return response()->json([
            'message' => 'added',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // CẬP NHẬT SỐ LƯỢNG
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $quantity = max(1, intval($request->quantity));

            $cart[$id]['quantity'] = $quantity;
            $cart[$id]['subtotal'] = $cart[$id]['price'] * $quantity;

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    // XÓA 1 SẢN PHẨM
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    // XÓA TOÀN BỘ GIỎ
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index');
    }
}
