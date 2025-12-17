@extends('adminlte::page')

@section('title', 'Đơn hàng')

@section('content_header')
<h1 class="text-info">Danh sách đơn hàng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
<table class="table table-bordered table-hover">

            <thead class="bg-dark">
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_phone }}</td>
                    <td>{{ number_format($order->total) }} đ</td>
                    <td>
                        <span class="badge 
                            @if($order->status == 'Chờ xử lý') bg-warning
                            @elseif($order->status == 'Đang giao') bg-primary
                            @else bg-success @endif">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">
                            Xem
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@stop
