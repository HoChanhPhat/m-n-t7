@extends('layouts.app')

@section('title', 'Danh mục: ' . $category->name)

@section('content')
<div class="container my-4">
    <h2 class="mb-4 fw-bold">Danh mục: {{ $category->name }}</h2>

    @if($products->isEmpty())
        <div class="alert alert-warning">Không có sản phẩm nào trong danh mục này.</div>
    @else
        <div class="row g-4">
           @foreach ($products as $product)
    <div class="col-md-3 mb-4">
        <x-product-card :product="$product" :wishlist="$wishlist" />
    </div>
@endforeach

        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
