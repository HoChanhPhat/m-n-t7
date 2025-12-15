<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;

class CheckoutController extends Controller
{
    // ================= HIỂN THỊ FORM THANH TOÁN =================
    public function index()
    {
        $cart = session('cart', []);
        $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

        // TÍNH GIẢM GIÁ NẾU ĐÃ CÓ SESSION
        $discount = 0;

        if (session()->has('coupon')) {
            $c = session('coupon');

            if ($c['type'] == 'percent') {
                $discount = ($total * $c['value']) / 100;
            } else {
                $discount = $c['value'];
            }

            if ($discount > $total) $discount = $total;
        }

        $finalTotal = $total - $discount;

        return view('checkout.index', compact('cart', 'total', 'discount', 'finalTotal'));
    }

    // ================= ÁP DỤNG MÃ GIẢM GIÁ =================
    public function applyCoupon(Request $request)
{
    $coupon = Coupon::where('code', $request->coupon)->first();

    if (!$coupon) {
        return response()->json(['error' => 'Mã không tồn tại.']);
    }

    if (!$coupon->is_active) {
        return response()->json(['error' => 'Mã giảm giá đang tắt.']);
    }

    if ($coupon->start_date && $coupon->start_date->isFuture()) {
        return response()->json(['error' => 'Mã chưa đến ngày sử dụng.']);
    }

    if ($coupon->end_date && $coupon->end_date->isPast()) {
        return response()->json(['error' => 'Mã đã hết hạn.']);
    }

    if ($coupon->limit > 0 && $coupon->used >= $coupon->limit) {
        return response()->json(['error' => 'Mã đã dùng hết lượt.']);
    }

    // Lưu vào SESSION
    session()->put('coupon', [
        'id' => $coupon->id,
        'code' => $coupon->code,
        'type' => $coupon->type,
        'value' => $coupon->value,
    ]);

    // Tính tổng mới
    $cart = session('cart', []);
    $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

    $discount = $coupon->type == 'percent'
        ? ($total * $coupon->value / 100)
        : $coupon->value;

    $finalTotal = max(0, $total - $discount);

    return response()->json([
        'success' => 'Áp dụng mã thành công!',
        'final_total' => $finalTotal
    ]);
}


    // ================= XỬ LÝ ĐẶT HÀNG =================
    public function placeOrder(Request $request)
    {
        // VALIDATE
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'customer_email'   => 'nullable|email',
            'customer_address' => 'required|string|max:500',
            'payment_method'   => 'required|in:COD,BANK',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        // CHECK KHO
        foreach ($cart as $id => $item) {
            $product = Product::find($id);

            if (!$product) {
                return back()->with('error', 'Sản phẩm không tồn tại!');
            }

            if ($product->quantity < $item['quantity']) {
                return back()->with('error', 'Sản phẩm "' . $product->name . '" chỉ còn ' . $product->quantity . ' cái!');
            }
        }

        // TÍNH TỔNG
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $discount = 0;

        if (session()->has('coupon')) {
            $c = session('coupon');

            if ($c['type'] == 'percent') {
                $discount = ($total * $c['value']) / 100;
            } else {
                $discount = $c['value'];
            }

            if ($discount > $total) $discount = $total;
        }

        $finalTotal = $total - $discount;

        // TẠO ORDER
        $order = Order::create([
            'user_id'         => auth()->id(),
            'customer_name'   => $request->customer_name,
            'customer_phone'  => $request->customer_phone,
            'customer_email'  => $request->customer_email,
            'customer_address'=> $request->customer_address,
            'payment_method'  => $request->payment_method,
            'total'           => $finalTotal,
            'status'          => 'Chờ xử lý',
        ]);

        // ORDER ITEMS
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            $product = Product::find($id);
            if ($product) {
                $product->quantity      -= $item['quantity'];
                $product->sold_quantity += $item['quantity'];
                $product->save();
            }
        }

        // TĂNG USED COUPON
        if (session()->has('coupon')) {
            $coupon = Coupon::find(session('coupon.id'));
            if ($coupon) {
                $coupon->used += 1;
                $coupon->save();
            }
        }

        // CLEAR SESSION
        session()->forget('cart');
        session()->forget('coupon');

        return view('checkout.success', compact('order'));
    }
}
