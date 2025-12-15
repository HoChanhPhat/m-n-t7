<style>
#mainImage {
    transition: transform 0.25s ease, opacity 0.25s ease;
}
.mainImage-zoom {
    transform: scale(1.08);
}
.thumb-item {
    transition: transform 0.2s ease;
}
.thumb-item:hover {
    transform: scale(1.08);
}
</style>
<script>
function changeImage(src) {
    const img = document.getElementById("mainImage");

    img.classList.add("mainImage-zoom");
    img.style.opacity = 0;

    setTimeout(() => {
        img.src = src;      
        img.style.opacity = 1;
    }, 180);

    setTimeout(() => {
        img.classList.remove("mainImage-zoom");
    }, 250);
}
</script>



@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mt-5">

    <div class="row">

        {{-- ================= HÌNH ẢNH ================= --}}
        <div class="col-md-6">

            {{-- Ảnh chính --}}
            <div class="main-image mb-3 text-center">
                <img id="mainImage" 
                     src="{{ asset('storage/' . $product->image) }}" 
                     class="img-fluid rounded border shadow-sm"
                     style="max-height: 450px; object-fit: contain;">
            </div>

            {{-- Thumbnail ảnh phụ --}}
            @if ($product->images->count() > 0)
            <div class="d-flex gap-2 flex-wrap">

                {{-- Ảnh chính cũng đưa vào danh sách thumbnail --}}
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="thumb-item border rounded"
                     style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                     onclick="changeImage(this.src)">

                @foreach ($product->images as $img)
                    <img src="{{ asset('storage/' . $img->image_path) }}"
                         class="thumb-item border rounded"
                         style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                         onclick="changeImage(this.src)">
                @endforeach

            </div>
            @endif
        </div>

        {{-- ================= THÔNG TIN SẢN PHẨM ================= --}}
        <div class="col-md-6">

            <h3 class="fw-bold">{{ $product->name }}</h3>

            <p class="text-warning fw-bold">
                {{ $avgRating }} / 5 ⭐
                <span class="text-secondary">({{ $product->reviews->count() }} đánh giá)</span>
            </p>

            <p>Danh mục: <strong>{{ $product->category->name ?? 'Không rõ' }}</strong></p>
            <p>Thương hiệu: <strong>{{ $product->brand->name ?? 'Không rõ' }}</strong></p>

            <h4 class="text-danger fw-bold">
                {{ number_format($product->price, 0, ',', '.') }} đ
            </h4>

            <p>Số lượng còn: {{ $product->quantity }}</p>

          






@php
    use App\Models\Wishlist;

    $isInWishlist = auth()->check() &&
                    Wishlist::where('user_id', auth()->id())
                            ->where('product_id', $product->id)
                            ->exists();
@endphp



<div class="d-flex gap-2 mt-3 align-items-center">

    {{-- Nhập số lượng --}}
    <input type="number" id="quantity" value="1" min="1"
           class="form-control" style="width: 90px"
           @if($product->quantity == 0) disabled @endif>

    {{-- Thêm vào giỏ --}}
    @if($product->quantity > 0)
        <button onclick="addToCart({{ $product->id }})"
                class="btn btn-primary flex-fill">
            <i class="bi bi-cart-plus"></i> Thêm vào giỏ
        </button>
    @else
        <button class="btn btn-secondary flex-fill" disabled>Hết hàng</button>
    @endif

    {{-- Mua ngay --}}
    @if($product->quantity > 0)
        <button onclick="buyNow({{ $product->id }})"
                class="btn btn-danger flex-fill">
            Mua ngay
        </button>
    @else
        <button class="btn btn-outline-secondary flex-fill" disabled>
            Hết hàng
        </button>
    @endif

    {{-- Trái tim --}}
    <button class="btn btn-link p-0 ms-2"
            onclick="toggleWishlist({{ $product->id }}, this)">
        <i class="fa fa-heart {{ $isInWishlist ? 'text-danger' : 'text-secondary' }}"
           style="font-size: 28px; cursor: pointer;"></i>
    </button>

</div>

        </div>

    </div>


    {{-- ================= MÔ TẢ & THÔNG SỐ ================= --}}
    <div class="row mt-5">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-target="#desc" data-bs-toggle="tab">Mô tả chi tiết</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-target="#spec" data-bs-toggle="tab">Thông số kỹ thuật</button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 p-3">
                <div class="tab-pane fade show active" id="desc">
                    {!! $product->description !!}
                </div>

                <div class="tab-pane fade" id="spec">
                    @if(!empty($product->specs))
                        <table class="table table-bordered">
                            @foreach($product->specs as $k => $v)
                                <tr><th>{{ $k }}</th><td>{{ $v }}</td></tr>
                            @endforeach
                        </table>
                    @else
                        <p>Chưa có thông số kỹ thuật.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    {{-- ================= ĐÁNH GIÁ ================= --}}
    <div class="mt-5">
        <h4 class="mb-3">Đánh giá sản phẩm</h4>

        @auth
        <form action="{{ route('products.review', $product->id) }}" method="POST" class="mb-4 p-3 border rounded">
            @csrf
            <label class="fw-bold">Chọn số sao:</label>
            <select name="rating" class="form-select w-25 mb-2" required>
                <option value="5">5 sao</option>
                <option value="4">4 sao</option>
                <option value="3">3 sao</option>
                <option value="2">2 sao</option>
                <option value="1">1 sao</option>
            </select>

            <textarea name="comment" class="form-control mb-2" rows="3"
                      placeholder="Viết cảm nhận của bạn..."></textarea>

            <button class="btn btn-primary">Gửi đánh giá</button>
        </form>
        @endauth

        @foreach($reviews as $review)
            <div class="p-3 border rounded mb-3 bg-white">
                <strong>{{ $review->user->name }}</strong>
                <span class="text-warning">{{ $review->rating }} ⭐</span>
                <p class="mb-1">{{ $review->comment }}</p>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
        @endforeach

        @if($reviews->count() == 0)
            <p class="text-muted">Chưa có đánh giá nào.</p>
        @endif
    </div>


    {{-- ================= SẢN PHẨM LIÊN QUAN ================= --}}
    <div class="mt-5">
        <h4 class="mb-3">Sản phẩm liên quan</h4>
        <div class="row">
            @foreach ($related as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $item->image) }}"
                             class="card-img-top" 
                             alt="{{ $item->name }}">

                        <div class="card-body text-center">
                            <h6 class="text-truncate">{{ $item->name }}</h6>
                            <p class="text-danger fw-bold">{{ number_format($item->price, 0, ',', '.') }} đ</p>
                            <a href="{{ route('web.products.show', $item->id) }}" 
                               class="btn btn-outline-primary btn-sm">Xem</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>


{{-- ================= JS đổi ảnh ================= --}}
<script>
function changeImage(src) {
    document.getElementById("mainImage").src = src;
}
</script>

@endsection
