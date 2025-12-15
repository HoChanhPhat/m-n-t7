@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')

<h3 class="mb-4">Giỏ hàng của bạn</h3>

@if (count($cart) == 0)
    <p>Giỏ hàng đang trống.</p>
@else
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tạm tính</th>
                <th>Hành động</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cart as $id => $item)
            <tr>
                <td width="100">
                    <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid">
                </td>

                <td>{{ $item['name'] }}</td>

                <td class="text-danger fw-bold">
                    {{ number_format($item['price']) }}₫
                </td>

                <td width="120">
                    <form action="{{ route('cart.update', $id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}"
                            class="form-control text-center">
                        <button class="btn btn-sm btn-primary mt-2">Cập nhật</button>
                    </form>
                </td>

                <td class="fw-bold">
                    {{ number_format($item['subtotal']) }}₫
                </td>

                <td>
                    <a href="{{ route('cart.remove', $id) }}"
                       class="btn btn-danger btn-sm">
                        Xóa
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-end">
        <h4>Tổng tiền: <strong class="text-danger">{{ number_format($total) }}₫</strong></h4>

        <a href="{{ route('cart.clear') }}" class="btn btn-warning mt-3">
            Xóa toàn bộ giỏ hàng
        </a>

        <a href="{{ route('checkout') }}" class="btn btn-success mt-3">
            Thanh toán
        </a>
    </div>
@endif

@endsection
