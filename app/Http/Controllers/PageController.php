<?php  

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Wishlist;                 // ✔ THÊM DÒNG NÀY
use Illuminate\Support\Facades\Auth;     // ✔ THÊM DÒNG NÀY

class PageController extends Controller
{
    public function home()
    {
        // Sản phẩm nổi bật (ví dụ: theo sold_quantity)
        $featured = Product::orderBy('sold_quantity', 'desc')
            ->take(4)
            ->get();

        // Sản phẩm mới nhất
        $latest = Product::latest()
            ->take(8)
            ->get();

        // Danh sách product_id đã yêu thích của user hiện tại
        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray()
            : [];

        return view('home', compact('featured', 'latest', 'wishlist'));
    }
}
