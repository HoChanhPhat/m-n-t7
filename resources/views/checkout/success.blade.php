@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container my-5">

    <div class="text-center mb-4">
        <h2>🎉 Đặt hàng thành công!</h2>
        <p>Cảm ơn bạn đã mua hàng.</p>
        <p>Mã đơn hàng của bạn là: <strong>#{{ $order->id }}</strong></p>
    </div>

    {{-- ===== THÔNG BÁO THEO PHƯƠNG THỨC THANH TOÁN ===== --}}
    @if(($order->payment_method ?? '') === 'BANK')
        <div class="alert alert-info border rounded p-4">
            <h5 class="fw-bold mb-3">✅ Bạn đã chọn: Chuyển khoản ngân hàng</h5>

            <p class="mb-2">Vui lòng chuyển khoản theo thông tin dưới đây để shop xác nhận đơn nhanh hơn:</p>

            <div class="border rounded p-3 bg-light">
                <p class="mb-1"><strong>Ngân hàng:</strong> Vietcombank</p>
                <p class="mb-1"><strong>Số tài khoản:</strong> 123456789</p>
                <p class="mb-1"><strong>Tên tài khoản:</strong> TechStore</p>

                <hr class="my-2">

                <p class="mb-1"><strong>Nội dung chuyển khoản:</strong></p>
                <div class="text-danger fw-bold">
                    TECHSTORE_{{ $order->id }}_{{ $order->customer_phone }}
                </div>

                <small class="text-muted d-block mt-2">
                    Lưu ý: Nhập đúng nội dung để đối soát nhanh. Sau khi nhận thanh toán, đơn sẽ được chuyển sang trạng thái xử lý.
                </small>
            </div>

            <div class="mt-3">
                <span class="badge bg-warning text-dark">
                    Trạng thái hiện tại: {{ $order->status ?? 'Chờ xác nhận thanh toán' }}
                </span>
                <span class="badge bg-secondary ms-2">
                    Thanh toán: {{ $order->payment_status ?? 'unpaid' }}
                </span>
            </div>
        </div>
    @else
        <div class="alert alert-success border rounded p-4">
            <h5 class="fw-bold mb-2">✅ Bạn đã chọn: Thanh toán khi nhận hàng (COD)</h5>
            <p class="mb-0">
                Shop sẽ liên hệ xác nhận và giao hàng đến bạn. Bạn thanh toán khi nhận hàng.
            </p>

            <div class="mt-3">
                <span class="badge bg-warning text-dark">
                    Trạng thái hiện tại: {{ $order->status ?? 'Chờ xử lý' }}
                </span>
            </div>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="btn btn-primary">Về trang chủ</a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-dark ms-2">Xem đơn hàng của tôi</a>
    </div>

</div>
@endsection
