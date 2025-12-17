<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }

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

        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('web.products.all', compact('products', 'brands', 'wishlist'));
    }

    // ===============================
    // 2) Chi tiết sản phẩm
    // ===============================
    public function show(Request $request, $id)
    {
        $product = Product::with([
            'brand',
            'category',
            'reviews.user',
            'images'
        ])->findOrFail($id);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = $product->reviews()->latest()->get();
        $avgRating = round($product->reviews()->avg('rating'), 1);

        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        // ✅ myReview + editMode để show.blade.php dùng cho "Sửa đánh giá"
        $myReview = Auth::check()
            ? Review::where('user_id', Auth::id())->where('product_id', $product->id)->first()
            : null;

        $editMode = $request->query('edit_review') == 1;

        // ✅ chỉ cho tạo đánh giá mới nếu đi từ order đã giao & đúng sản phẩm & chưa từng review
        $canReview = false;
        $orderId = $request->query('order_id');

        if (Auth::check() && $orderId) {
            $hasPurchasedThisOrder = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.id', $orderId)
                ->where('orders.user_id', Auth::id())
                ->where('orders.status', 'Đã giao')
                ->where('order_items.product_id', $product->id)
                ->exists();

            $alreadyReviewed = $myReview != null;

            $canReview = $hasPurchasedThisOrder && !$alreadyReviewed;
        }

        return view('web.products.show', compact(
            'product', 'related', 'reviews', 'avgRating', 'wishlist',
            'canReview', 'myReview', 'editMode'
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

        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('web.products.by_category', compact('category', 'products', 'wishlist'));
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

        $wishlist = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('web.products.search', compact('query', 'products', 'wishlist'));
    }

    // ===============================
    // 5) Tạo đánh giá (mới)
    // ===============================
    public function addReview(Request $request, $id)
    {
        abort_unless(Auth::check(), 403);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_id' => 'required|integer'
        ]);

        $orderId = $request->order_id;

        $hasPurchasedThisOrder = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.id', $orderId)
            ->where('orders.user_id', Auth::id())
            ->where('orders.status', 'Đã giao')
            ->where('order_items.product_id', $id)
            ->exists();

        if (!$hasPurchasedThisOrder) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm trong đơn đã giao.');
        }

        $alreadyReviewed = Review::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'rating' => (int) $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }

    // ===============================
    // 6) Sửa đánh giá
    // ===============================
    public function updateReview(Request $request, $id)
    {
        abort_unless(Auth::check(), 403);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_id' => 'required|integer'
        ]);

        $orderId = $request->order_id;

        $ok = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.id', $orderId)
            ->where('orders.user_id', Auth::id())
            ->where('orders.status', 'Đã giao')
            ->where('order_items.product_id', $id)
            ->exists();

        if (!$ok) {
            return back()->with('error', 'Bạn chỉ có thể sửa đánh giá của sản phẩm trong đơn đã giao.');
        }

        $review = Review::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if (!$review) {
            return back()->with('error', 'Không tìm thấy đánh giá để sửa.');
        }

        $review->update([
            'rating' => (int) $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Đã cập nhật đánh giá!');
    }
}
