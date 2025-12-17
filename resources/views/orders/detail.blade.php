@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h3 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h3>

    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

    @php
        // ✅ Tối ưu: lấy 1 lần danh sách sản phẩm user đã đánh giá
        $reviewedProductIds = [];
        if(auth()->check()){
            $reviewedProductIds = \App\Models\Review::where('user_id', auth()->id())
                ->pluck('product_id')
                ->toArray();
        }
    @endphp

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Sản phẩm</th>
                <th>SL</th>
                <th>Giá</th>
                <th>Tổng</th>
                <th>Đánh giá</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->items as $item)
                @php
                    $productId = $item->product_id; // hoặc $item->product->id nếu bạn muốn chắc
                    $isReviewed = in_array($productId, $reviewedProductIds);
                @endphp

                <tr>
                    <td>
                        <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                             width="60" height="60" style="object-fit:cover;">
                    </td>

                    <td>{{ $item->product->name }}</td>

                    <td>{{ $item->quantity }}</td>

                    <td>{{ number_format($item->price) }} đ</td>

                    <td>{{ number_format($item->price * $item->quantity) }} đ</td>

                    <td>
                        @if($order->status === 'Đã giao')
                            @if(!$isReviewed)
                                <a href="{{ route('web.products.show', $productId) }}?order_id={{ $order->id }}#reviews"
                                   class="btn btn-sm btn-outline-primary">
                                    Đánh giá
                                </a>
                            @else
                                <a href="{{ route('web.products.show', $productId) }}?order_id={{ $order->id }}&edit_review=1#reviews"
                                   class="btn btn-sm btn-outline-warning">
                                    Sửa đánh giá
                                </a>
                            @endif
                        @else
                            <button class="btn btn-sm btn-secondary" disabled>
                                Chưa thể đánh giá
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end mt-4">Tổng tiền: <strong>{{ number_format($order->total) }} đ</strong></h4>
</div>
@endsection
