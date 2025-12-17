@extends('adminlte::page')

@section('title', 'Chi tiết doanh thu')

@section('content_header')
    <h1>{{ $title }}</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <b>Tổng tiền (theo sản phẩm):</b>
            <span class="text-danger">{{ number_format($grandTotal) }} đ</span>
        </div>

        <a href="{{ route('admin.revenue.index') }}" class="btn btn-secondary btn-sm">
            Quay lại
        </a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#Đơn</th>
                    <th>Ngày tạo</th>
                    <th>Sản phẩm</th>
                    <th>SL</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rows as $r)
                    <tr>
                        <td>#{{ $r->order_id }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $r->product_name }}</td>
                        <td>{{ $r->quantity }}</td>
                        <td>{{ number_format($r->price) }} đ</td>
                        <td class="text-danger fw-bold">{{ number_format($r->line_total) }} đ</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Không có dữ liệu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
