@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4">Danh sách yêu thích</h3>

    <div class="row">
        @forelse($items as $product)
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="card-img-top" alt="{{ $product->name }}"
                     style="height: 200px; object-fit: cover;">

                <div class="card-body text-center">
                    <h5 class="text-truncate">{{ $product->name }}</h5>

                    <p class="text-danger fw-bold">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </p>

                    <button class="btn btn-outline-danger w-100"
                        onclick="toggleWishlist({{ $product->id }}, this)">
                        <i class="fa fa-heart text-danger"></i>
                        Bỏ yêu thích
                    </button>
                </div>
            </div>
        </div>
        @empty
        <p>Bạn chưa có sản phẩm yêu thích nào.</p>
        @endforelse
    </div>
</div>
@endsection
