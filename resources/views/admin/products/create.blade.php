@extends('adminlte::page')

@section('title', 'Thêm sản phẩm mới')

@section('content_header')
    <h1 class="text-primary">Thêm sản phẩm mới</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Tên sản phẩm --}}
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            {{-- Danh mục --}}
            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Thương hiệu --}}
            <div class="form-group">
                <label for="brand_id">Thương hiệu</label>
                <select name="brand_id" id="brand_id" class="form-control" required>
                    <option value="">-- Chọn thương hiệu --</option>
                </select>
            </div>

            {{-- Giá --}}
            <div class="form-group">
                <label for="price">Giá (VNĐ)</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>



            
            {{-- số lượng --}}
      <div class="form-group">
    <label for="quantity">Số lượng tồn kho</label>
    <input type="number" name="quantity" id="quantity" class="form-control"
           min="0" value="0" required>
</div>



            {{-- Mô tả --}}
            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="form-control" rows="4"></textarea>
            </div>


<div class="form-group mt-3">
    <label for="specs">Thông số kỹ thuật (JSON hoặc dạng text)</label>
   <textarea name="specs" id="specs" class="form-control" rows="5"
placeholder='{"CPU":"i5 1240P", "RAM":"16GB", "Ổ cứng":"512GB SSD"}'>
{{ old('specs') }}
</textarea>

</div>


            {{-- Hình ảnh --}}
    {{-- Ảnh chính --}}
<div class="form-group">
    <label for="main_image">Ảnh chính</label>
    <input type="file" name="main_image" id="main_image" class="form-control">
</div>

{{-- Ảnh phụ --}}
<div class="form-group">
    <label for="images">Ảnh phụ (có thể chọn nhiều)</label>
    <input type="file" name="images[]" id="images" class="form-control" multiple>
</div>



            {{-- Nút --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Lưu sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>



        
            
            
        </form>
    </div>
</div>
@stop

@section('js')
<script>
document.getElementById('category_id').addEventListener('change', function () {
    const categoryId = this.value;
    const brandSelect = document.getElementById('brand_id');
    brandSelect.innerHTML = '<option value="">-- Đang tải thương hiệu... --</option>';

    if (categoryId) {
        fetch(`/admin/brands/by-category/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                brandSelect.innerHTML = '<option value="">-- Chọn thương hiệu --</option>';
                data.forEach(brand => {
                    const option = document.createElement('option');
                    option.value = brand.id;
                    option.textContent = brand.name;
                    brandSelect.appendChild(option);
                });
            })
            .catch(() => {
                brandSelect.innerHTML = '<option value="">-- Không thể tải thương hiệu --</option>';
            });
    } else {
        brandSelect.innerHTML = '<option value="">-- Chọn thương hiệu --</option>';
    }
});
</script>
@stop
