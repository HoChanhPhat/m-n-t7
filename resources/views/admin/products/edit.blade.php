@extends('adminlte::page')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content_header')
    <h1>Chỉnh sửa sản phẩm</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- Tên sản phẩm --}}
            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            {{-- Thương hiệu --}}
            <div class="form-group">
                <label>Thương hiệu</label>
                <select name="brand_id" class="form-control">
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Danh mục --}}
            <div class="form-group">
                <label>Danh mục</label>
                <select name="category_id" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Giá --}}
            <div class="form-group">
                <label>Giá (VNĐ)</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            {{-- Số lượng --}}
            <div class="form-group">
                <label for="quantity">Số lượng tồn kho</label>
                <input type="number" name="quantity" id="quantity" class="form-control"
                       min="0" value="{{ $product->quantity }}" required>
            </div>

            {{-- Mô tả --}}
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
            </div>

            {{-- Thông số kỹ thuật --}}
            <div class="form-group mt-3">
                <label for="specs">Thông số kỹ thuật (JSON hoặc dạng text)</label>
                <textarea name="specs" id="specs" class="form-control" rows="6">
{{ json_encode(old('specs', $product->specs), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                </textarea>
            </div>

            {{-- Ảnh chính hiện tại --}}
            <div class="form-group mt-3">
                <label>Ảnh chính hiện tại</label><br>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" width="140" style="border-radius:6px;">
                @else
                    <span class="text-muted">Không có ảnh chính</span>
                @endif
            </div>

            {{-- Upload ảnh chính mới --}}
            <div class="form-group mt-3">
                <label>Ảnh chính mới (nếu muốn thay)</label>
                <input type="file" name="main_image" class="form-control">
            </div>

            {{-- Ảnh phụ hiện có --}}
            <div class="form-group mt-4">
                <label>Ảnh phụ hiện có</label><br>

                @if($product->images->count() > 0)
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}" 
                             width="110" class="m-1" style="border-radius:6px;">
                    @endforeach
                @else
                    <span class="text-muted">Không có ảnh phụ</span>
                @endif
            </div>

            {{-- Thêm ảnh phụ mới --}}
            <div class="form-group mt-3">
                <label>Thêm ảnh phụ mới</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            {{-- Nút --}}
            <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Hủy</a>
        </form>
    </div>
</div>
@stop
