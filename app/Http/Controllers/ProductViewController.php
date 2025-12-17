<?php  

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductViewController extends Controller
{
    // ===============================
    // 1) Hiển thị danh sách sản phẩm (trang TẤT CẢ SẢN PHẨM)
    // ===============================
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category']);

        // Tìm kiếm tên
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo giá
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Lọc theo thương hiệu
        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }

        // Sắp xếp
        switch ($request->sort_by) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $brands = Brand::all();

        // Lấy danh sách ID sản phẩm user đã wishlist
        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        // 👉 Trả về view KHÁCH, không phải admin
        return view('web.products.all', compact('products', 'brands', 'wishlist'));
    }

    // ===============================
    // 2) Chi tiết sản phẩm
    // ===============================
    public function show($id)
    {
        $product = Product::with([
            'brand',
            'category',
            'reviews.user',
            'images'
        ])->findOrFail($id);

        // sản phẩm liên quan
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = $product->reviews()->latest()->get();
        $avgRating = round($product->reviews()->avg('rating'), 1);

        // Lấy wishlist của user
        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('web.products.show', compact(
            'product', 'related', 'reviews', 'avgRating', 'wishlist'
        ));
    }

    // ===============================
    // 3) Sản phẩm theo danh mục
    // ===============================
    public function showByCategory($id)
    {
        $category = Category::findOrFail($id);

        $products = Product::where('category_id', $id)
            ->with(['brand', 'category'])
            ->paginate(12);

        // Lấy wishlist
        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('products.by_category', compact('category', 'products', 'wishlist'));
    }

    // ===============================
    // 4) Trang tìm kiếm sản phẩm
    // ===============================
    public function search(Request $request)
    {
        $query = $request->input('q');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12);

        // Lấy wishlist
        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('web.products.search', compact('query', 'products', 'wishlist'));
    }

    // ===============================
    // 5) Gửi đánh giá
    // ===============================
    public function addReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }
}
