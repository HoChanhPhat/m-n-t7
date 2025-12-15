<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;

class BrandController extends Controller
{
    // Hiển thị danh sách thương hiệu
    public function index()
    {
        $brands = Brand::with('category')->get();
        return view('admin.brands.index', compact('brands'));
    }

    // Form tạo mới thương hiệu
    public function create()
    {
        $categories = Category::all();
        return view('admin.brands.create', compact('categories'));
    }
public function byCategory($categoryId)
{
    $brands = Brand::where('category_id', $categoryId)->get();

    return response()->json($brands);
}

    // Lưu thương hiệu mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Brand::create([
            'name' => $request->name,
            'logo' => $request->logo ?? null,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Đã thêm thương hiệu thành công!');
    }

    // API: Lấy thương hiệu theo danh mục (cho dropdown)
    public function getByCategory($id)
    {
        $brands = Brand::where('category_id', $id)->get(['id', 'name']);
        return response()->json($brands);
    }
}
