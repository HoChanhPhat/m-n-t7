@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="container">
    <h3 class="mb-4">Kết quả tìm kiếm cho: 
        <span class="text-primary">"{{ $query }}"</span>
    </h3>

    @if ($products->count() > 0)
        <div class="row g-4">
          @foreach ($products as $product)
    <div class="col-md-3 mb-4">
        <x-product-card :product="$product" :wishlist="$wishlist" />
    </div>
@endforeach

        </div>
    @else
        <div class="alert alert-warning mt-4">
            Không tìm thấy sản phẩm nào phù hợp với từ khóa 
            "<b>{{ $query }}</b>".
        </div>
    @endif
</div>
@endsection
