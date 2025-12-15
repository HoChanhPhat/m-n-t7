<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminBrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('category')->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        // LẤY TẤT CẢ DANH MỤC ĐỂ HIỂN THỊ TRONG DROPDOWN
        $categories = Category::all();
        return view('admin.brands.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // VALIDATE YÊU CẦU PHẢI CÓ category_id
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        // LƯU THƯƠNG HIỆU
        Brand::create([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Thêm thương hiệu thành công!');
    }

    public function edit(Brand $brand)
    {
        $categories = Category::all();
        return view('admin.brands.edit', compact('brand', 'categories'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $brand->update([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return back()->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return back()->with('success', 'Xóa thành công!');
    }

    // API: Lấy thương hiệu theo category
    public function getByCategory($categoryId)
    {
        return response()->json(
            Brand::where('category_id', $categoryId)->get()
        );
    }
}
