@extends('adminlte::page')

@section('title', 'Chi tiết đơn hàng')

@section('content_header')
<h1 class="text-info">Chi tiết đơn hàng #{{ $order->id }}</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-6">

        {{-- Thông tin khách hàng (SÁNG) --}}
        <div class="card">
            <div class="card-header bg-primary text-white">Thông tin khách hàng</div>
            <div class="card-body">
                <p><b>Họ tên:</b> {{ $order->customer_name }}</p>
                <p><b>Số điện thoại:</b> {{ $order->customer_phone }}</p>
                <p><b>Email:</b> {{ $order->customer_email ?? 'Không có' }}</p>
                <p><b>Địa chỉ:</b> {{ $order->customer_address }}</p>
                <p><b>Tổng tiền:</b> {{ number_format($order->total) }} đ</p>
                <p><b>Trạng thái:</b>
                    <span class="badge bg-info">{{ $order->status }}</span>
                </p>
            </div>
        </div>

        {{-- Cập nhật trạng thái (SÁNG) --}}
        <div class="card mt-3">
            <div class="card-header bg-warning">Cập nhật trạng thái</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <select name="status" class="form-control mb-2">
                        <option value="Chờ xử lý" {{ $order->status == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="Đang giao" {{ $order->status == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
                        <option value="Đã giao" {{ $order->status == 'Đã giao' ? 'selected' : '' }}>Đã giao</option>
                    </select>
                    <button class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>

    </div>

    <div class="col-md-6">

        {{-- Sản phẩm đã đặt (SÁNG) --}}
        <div class="card">
            <div class="card-header bg-primary text-white">Sản phẩm đã đặt</div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>SL</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <img src="{{ asset('uploads/products/' . $item->product->image) }}" width="60">
                            </td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price) }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@stop
