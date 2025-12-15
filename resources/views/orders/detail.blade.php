@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h3 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h3>

    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Sản phẩm</th>
                <th>SL</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>
                    <img src="{{ asset('uploads/products/' . $item->product->image) }}" 
                         width="60" height="60" style="object-fit:cover;">
                </td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price) }} đ</td>
                <td>{{ number_format($item->price * $item->quantity) }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-end mt-4">Tổng tiền: <strong>{{ number_format($order->total) }} đ</strong></h4>
</div>
@endsection
