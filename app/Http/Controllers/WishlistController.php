<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function toggle($product_id)
    {
        // Nếu user đăng nhập → lưu DB
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product_id)
                ->first();

            if ($exists) {
                $exists->delete();
                $status = 'removed';
            } else {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product_id
                ]);
                $status = 'added';
            }

            $count = Wishlist::where('user_id', Auth::id())->count();
        } 
        
        else {
            // KHÁCH → lưu Session
            $wishlist = session()->get('wishlist', []);

            if (in_array($product_id, $wishlist)) {
                $wishlist = array_diff($wishlist, [$product_id]);
                $status = 'removed';
            } else {
                $wishlist[] = $product_id;
                $status = 'added';
            }

            session()->put('wishlist', $wishlist);

            $count = count($wishlist);
        }

        return response()->json([
            'status' => $status,
            'wishlist_count' => $count
        ]);
    }

    public function index()
    {
        if (Auth::check()) {
            $ids = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        } else {
            $ids = session()->get('wishlist', []);
        }

        $items = Product::whereIn('id', $ids)->get();

        return view('wishlist.index', compact('items'));
 
    }


    public function productsByIds(Request $request)
{
    $ids = collect(explode(',', $request->query('ids', '')))
        ->filter()
        ->map(fn($x) => (int)$x)
        ->unique()
        ->values()
        ->all();

    if (empty($ids)) return response()->json([]);

    $products = Product::whereIn('id', $ids)->get();

    // giữ đúng thứ tự theo ids
    $products = $products->sortBy(fn($p) => array_search($p->id, $ids))->values();

    return response()->json($products);
}

}


