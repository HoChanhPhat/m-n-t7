@props(['product', 'wishlist' => []])

<div class="card h-100 shadow-sm position-relative product-card" 
     style="cursor: pointer;" 
     onclick="window.location='{{ route('web.products.show', $product->id) }}'">

    {{-- ❤️ ICON WISHLIST (luôn hiện) --}}
    @php $liked = in_array($product->id, $wishlist); @endphp

    <i class="fa fa-heart wishlist-icon"
       onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)"
       style="
            position: absolute;
            top: 10px; right: 10px;
            font-size: 22px;
            cursor: pointer;
            color: {{ $liked ? 'red' : '#ccc' }};
       ">
    </i>

    {{-- ẢNH --}}
    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">

    <div class="card-body text-center">

        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
        <p class="text-muted small">{{ $product->brand->name ?? 'Không rõ thương hiệu' }}</p>

        @php $avg = round($product->reviews()->avg('rating'), 1); @endphp
        <p class="mb-1 text-warning">{{ $avg }} ⭐</p>

        <p class="fw-bold text-danger">{{ number_format($product->price, 0, ',', '.') }} đ</p>

        <div class="d-flex gap-2 mt-2">
            <button class="btn btn-primary btn-sm w-50"
                    onclick="event.stopPropagation(); buyNow({{ $product->id }})">
                Mua ngay
            </button>

            <button class="btn btn-success btn-sm w-50"
                    onclick="event.stopPropagation(); addToCart({{ $product->id }})">
                <i class="bi bi-cart-plus"></i>
            </button>
        </div>
    </div>
</div>
