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

/* ===== Star rating color ===== */
#starPicker .star { color: #c9c9c9; }          /* sao rỗng */
#starPicker .star.filled { color: #f5c518; }   /* sao đầy vàng */
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

            <div class="tab-pane fade" id="spec">
    @php
        $specs = $product->specs;

        // Nếu specs là string JSON thì decode
        if (is_string($specs)) {
            $specs = json_decode($specs, true);
        }
    @endphp

    @if(is_array($specs) && count($specs))
        <table class="table table-bordered align-middle">
            <tbody>
            @foreach($specs as $key => $value)
                <tr>
                    <th style="width: 30%">
                        {{ ucfirst(str_replace('_',' ', $key)) }}
                    </th>
                    <td>
                        @if(is_array($value))
                            <table class="table table-sm table-bordered mb-0">
                                @foreach($value as $k2 => $v2)
                                    <tr>
                                        <th style="width: 35%">
                                            {{ ucfirst(str_replace('_',' ', $k2)) }}
                                        </th>
                                        <td>
                                            @if(is_array($v2))
                                                {{ json_encode($v2, JSON_UNESCAPED_UNICODE) }}
                                            @else
                                                {{ $v2 }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            {{ $value }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Chưa có thông số kỹ thuật.</p>
    @endif
</div>


    {{-- ================= ĐÁNH GIÁ ================= --}}
    <div class="mt-5" id="reviews">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="mb-0">Đánh giá sản phẩm</h4>

            <div class="text-end">
                <div class="fw-bold text-warning">
                    {{ number_format($avgRating, 1) }} / 5 ⭐
                </div>
                <small class="text-muted">{{ $product->reviews->count() }} đánh giá</small>
            </div>
        </div>

        {{-- Thông báo lỗi / thành công --}}
        @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        @auth
            {{-- ✅ Nếu đã có review và đang bật edit mode --}}
            @if(!empty($myReview) && !empty($editMode) && $editMode)
                <form action="{{ route('products.review.update', $product->id) }}" method="POST"
                      class="mb-4 p-3 border rounded bg-white shadow-sm">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="order_id" value="{{ request('order_id') }}">
                    <input type="hidden" name="rating" id="ratingInput" value="{{ $myReview->rating }}" required>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="fw-bold">Sửa số sao:</div>

                        <div id="starPicker" class="d-inline-flex align-items-center gap-1"
                             style="cursor:pointer; user-select:none;">
                            @for($i=1; $i<=5; $i++)
                                <span class="star" data-value="{{ $i }}"
                                      style="font-size: 22px; line-height: 1;">
                                    ☆
                                </span>
                            @endfor
                        </div>

                        <span id="starText" class="text-muted ms-2"></span>
                    </div>

                    <textarea name="comment" class="form-control mb-2" rows="3"
                              placeholder="Cập nhật cảm nhận của bạn...">{{ $myReview->comment }}</textarea>

                    <div class="d-flex align-items-center justify-content-between">
                        <small class="text-muted">
                            * Bạn có thể cập nhật đánh giá sau khi đã mua & nhận hàng.
                        </small>
                        <div class="d-flex gap-2">
                            <a class="btn btn-outline-secondary"
                               href="{{ route('web.products.show', $product->id) }}?order_id={{ request('order_id') }}#reviews">
                                Hủy
                            </a>
                            <button class="btn btn-warning" type="submit">
                                Cập nhật đánh giá
                            </button>
                        </div>
                    </div>
                </form>

            {{-- ✅ Nếu chưa có review và được phép đánh giá --}}
            @elseif(!empty($canReview) && $canReview === true)
                <form action="{{ route('products.review', $product->id) }}" method="POST"
                      class="mb-4 p-3 border rounded bg-white shadow-sm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ request('order_id') }}">

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="fw-bold">Chọn số sao:</div>

                        <div id="starPicker" class="d-inline-flex align-items-center gap-1"
                             style="cursor:pointer; user-select:none;">
                            @for($i=1; $i<=5; $i++)
                                <span class="star" data-value="{{ $i }}"
                                      style="font-size: 22px; line-height: 1;">
                                    ☆
                                </span>
                            @endfor
                        </div>

                        <span id="starText" class="text-muted ms-2"></span>
                    </div>

                    <input type="hidden" name="rating" id="ratingInput" value="5" required>

                    <textarea name="comment" class="form-control mb-2" rows="3"
                              placeholder="Chia sẻ cảm nhận thật của bạn về sản phẩm... (khuyến khích: tình trạng, pin, hiệu năng, đóng gói)"></textarea>

                    <div class="d-flex align-items-center justify-content-between">
                        <small class="text-muted">
                            * Chỉ khách hàng đã mua & nhận hàng mới được đánh giá.
                        </small>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-send"></i> Gửi đánh giá
                        </button>
                    </div>
                </form>

            {{-- ✅ Nếu đã có review nhưng không ở edit mode: gợi ý nút sửa --}}
            @elseif(!empty($myReview))
                <div class="alert alert-info mb-4">
                    ✅ Bạn đã đánh giá sản phẩm này.
                    <a class="ms-1"
                       href="{{ route('web.products.show', $product->id) }}?order_id={{ request('order_id') }}&edit_review=1#reviews">
                        Sửa đánh giá
                    </a>
                </div>

            @else
                <div class="alert alert-warning mb-4">
                    🔒 Bạn chỉ có thể đánh giá sau khi đã mua và nhận sản phẩm này.
                </div>
            @endif
        @else
            <div class="alert alert-info mb-4">
                🔐 Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh giá sản phẩm.
            </div>
        @endauth

        {{-- Danh sách review --}}
        @forelse($reviews as $review)
            <div class="p-3 border rounded mb-3 bg-white shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <strong>{{ $review->user->name }}</strong>
                    <span class="text-warning fw-bold">{{ $review->rating }} ⭐</span>
                </div>

                @if(!empty($review->comment))
                    <p class="mb-1 mt-2">{{ $review->comment }}</p>
                @endif

                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <p class="text-muted">Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
        @endforelse
    </div>

    {{-- Star picker script --}}
    <script>
    (function(){
        const stars = document.querySelectorAll('#starPicker .star');
        const input = document.getElementById('ratingInput');
        const text = document.getElementById('starText');

        if (!stars.length || !input) return;

        let current = parseInt(input.value || '5', 10);

        function render(val){
            stars.forEach(s => {
                const v = parseInt(s.dataset.value, 10);
                const filled = v <= val;
                s.textContent = filled ? '★' : '☆';
                s.classList.toggle('filled', filled);
            });

            const map = {1:'Tệ',2:'Chưa tốt',3:'Tạm ổn',4:'Tốt',5:'Rất hài lòng'};
            if (text) text.textContent = map[val] ? `(${map[val]})` : '';
        }

        stars.forEach(s => {
            s.addEventListener('mouseenter', () => render(parseInt(s.dataset.value, 10)));
            s.addEventListener('click', () => {
                current = parseInt(s.dataset.value, 10);
                input.value = current;
                render(current);
            });
        });

        const picker = document.getElementById('starPicker');
        if (picker) picker.addEventListener('mouseleave', () => render(current));

        render(current);
    })();
    </script>

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
@endsection
