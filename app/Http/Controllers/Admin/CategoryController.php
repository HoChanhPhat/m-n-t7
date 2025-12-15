<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Hiển thị form thêm danh mục
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu danh mục mới
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories,name|max:255',
    ], [
        'name.required' => 'Vui lòng nhập tên danh mục.',
        'name.unique' => 'Danh mục này đã tồn tại.',
        'name.max' => 'Tên danh mục không được quá 255 ký tự.',
    ]);

    Category::create([
        'name' => $request->name,
    ]);

    return redirect()->route('admin.categories.index')
                     ->with('success', 'Thêm danh mục thành công!');
}


    // Hiển thị form sửa danh mục
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật danh mục
    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update(['name' => $request->name]);
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công.');
    }

    // Xóa danh mục
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công.');
    }
}
