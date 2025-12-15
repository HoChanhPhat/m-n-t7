@extends('adminlte::page')


@section('content')
<div class="container mt-4">
    <h3>Chi tiết đơn hàng #{{ $order->id }}</h3>

    <p><strong>Khách hàng:</strong> {{ $order->customer_name }}</p>
    <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>

    <h5>Sản phẩm trong đơn:</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }} đ</p>

    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
        @csrf
        <label for="status"><strong>Cập nhật trạng thái:</strong></label>
        <select name="status" class="form-control w-25">
            <option value="Chờ xử lý" {{ $order->status == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="Đang giao" {{ $order->status == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
            <option value="Đã giao" {{ $order->status == 'Đã giao' ? 'selected' : '' }}>Đã giao</option>
        </select>
        <button type="submit" class="btn btn-success mt-3">Lưu thay đổi</button>
    </form>
</div>
@endsection
