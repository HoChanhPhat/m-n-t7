@extends('layouts.app')

@section('title', 'Tất cả sản phẩm')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">Tất cả sản phẩm</h2>

    {{-- ======================= BỘ LỌC ======================= --}}
    <form method="GET" action="{{ route('products.all') }}" class="mb-4 p-3 border rounded bg-light">
        <div class="row g-3">

            {{-- Tìm kiếm --}}
            <div class="col-md-3">
                <input type="text" name="search" class="form-control"
                       placeholder="Tìm tên sản phẩm..."
                       value="{{ request('search') }}">
            </div>

            {{-- Lọc giá --}}
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control"
                       placeholder="Giá từ"
                       value="{{ request('min_price') }}">
            </div>

            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control"
                       placeholder="Đến"
                       value="{{ request('max_price') }}">
            </div>

            {{-- Thương hiệu --}}
            <div class="col-md-2">
                <select name="brand" class="form-control">
                    <option value="">Thương hiệu</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" 
                            {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sắp xếp --}}
            <div class="col-md-2">
                <select name="sort_by" class="form-control">
                    <option value="">Sắp xếp</option>
                    <option value="price_asc"  {{ request('sort_by')=='price_asc' ? 'selected' : '' }}>Giá thấp → cao</option>
                    <option value="price_desc" {{ request('sort_by')=='price_desc' ? 'selected' : '' }}>Giá cao → thấp</option>
                    <option value="newest"     {{ request('sort_by')=='newest' ? 'selected' : '' }}>Mới nhất</option>
                </select>
            </div>

            <div class="col-md-1">
                <button class="btn btn-primary w-100">Lọc</button>
            </div>

        </div>
    </form>

    {{-- ======================= DANH SÁCH SẢN PHẨM ======================= --}}
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-3 mb-4">
           <x-product-card :product="$product" :wishlist="$wishlist" />

        </div>
        @endforeach
    </div>

    {{-- PHÂN TRANG --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

<script>
function addToCart(id) {
    fetch("/cart/add/" + id, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        const badge = document.getElementById("cart-badge");
        if (badge) {
            badge.innerText = data.cart_count;
            badge.classList.remove("d-none");
        }
        showPopup();
    });
}
</script>

@endsection
