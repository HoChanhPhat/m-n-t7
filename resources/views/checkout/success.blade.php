@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container text-center my-5">
    <h2>🎉 Đặt hàng thành công!</h2>
    <p>Cảm ơn bạn đã mua hàng.</p>
    <p>Mã đơn hàng của bạn là: <strong>#{{ $order->id }}</strong></p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Về trang chủ</a>
</div>
@endsection
