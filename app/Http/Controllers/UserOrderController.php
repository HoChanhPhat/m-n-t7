<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index() {
        $orders = Order::where('user_id', auth()->id())->orderBy('id', 'DESC')->get();
        return view('orders.index', compact('orders'));
    }

    public function detail($id) {
    $order = Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return view('orders.detail', compact('order'));
}

}
