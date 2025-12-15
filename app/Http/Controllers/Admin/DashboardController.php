<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Brand;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê cho các box
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalUsers    = User::count();
        $totalBrands   = Brand::count();

        // Thống kê cho biểu đồ → gom nhóm theo danh mục
        $productChart = Product::selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalBrands',
            'productChart'
        ));
    }
}
