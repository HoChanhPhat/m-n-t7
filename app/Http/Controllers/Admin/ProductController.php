<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Danh sách sản phẩm
    public function index()
    {
        $products = Product::with(['brand', 'category', 'images'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // Form thêm mới
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'description' => 'nullable|string',

            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',

            // Ảnh chính
            'main_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

            // Ảnh phụ
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

            'specs'       => 'nullable|string',
        ]);

        // Xử lý JSON specs
        if ($request->filled('specs')) {
            $decoded = json_decode($request->specs, true);
            $validated['specs'] = json_last_error() === JSON_ERROR_NONE
                ? $decoded
                : ['Ghi chú' => $request->specs];
        }

        // Lưu ảnh chính
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('products/main', 'public');
        }

        // Tạo sản phẩm
        $product = Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'quantity'    => $validated['quantity'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'brand_id'    => $validated['brand_id'],
            'image'       => $mainImagePath,
            'specs'       => $validated['specs'] ?? null,
        ]);

        // Lưu ảnh phụ
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }


    // Trang chỉnh sửa
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'description' => 'nullable|string',

            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',

            // Ảnh chính mới (nếu có)
            'main_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

            // Ảnh phụ mới
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

            'specs'       => 'nullable|string',
        ]);

        // Xử lý specs JSON
        if ($request->filled('specs')) {
            $decoded = json_decode($request->specs, true);
            $validated['specs'] = json_last_error() === JSON_ERROR_NONE
                ? $decoded
                : ['Ghi chú' => $request->specs];
        }

        // Xử lý ảnh chính
        if ($request->hasFile('main_image')) {

            // Xóa ảnh cũ
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('main_image')->store('products/main', 'public');
        }

        // Cập nhật dữ liệu sản phẩm
        $product->update($validated);

        // Thêm ảnh phụ mới (không xóa ảnh phụ cũ)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/gallery', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }


    // Xóa sản phẩm
    public function destroy(Product $product)
    {
        // Xóa ảnh chính
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Xóa ảnh phụ
        foreach ($product->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        }

        // Xóa sản phẩm
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }
}
