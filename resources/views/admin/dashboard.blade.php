@extends('adminlte::page')

@section('title', 'Bảng điều khiển')

@section('content_header')
    <h1 class="text-info fw-bold">Bảng điều khiển - TechStore</h1>
@stop

@section('content')
<div class="row">
    {{-- Tổng số sản phẩm --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalProducts }}</h3>
                <p>Sản phẩm hiện có</p>
            </div>
            <div class="icon">
                <i class="fas fa-laptop"></i>
            </div>
            <a href="{{ route('admin.products.index') }}" class="small-box-footer">
                Chi tiết <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Tổng số đơn hàng --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalOrders }}</h3>
                <p>Đơn hàng</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('orders.index') }}" class="small-box-footer">
                Xem tất cả <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Tổng số người dùng --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Người dùng</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ url('/admin/users') }}" class="small-box-footer">
                Xem thêm <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Tổng số thương hiệu --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalBrands }}</h3>
                <p>Thương hiệu</p>
            </div>
            <div class="icon">
                <i class="fas fa-industry"></i>
            </div>
            <a href="{{ route('admin.brands.index') }}" class="small-box-footer">
                Chi tiết <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

{{-- Biểu đồ thống kê sản phẩm theo danh mục --}}
<div class="card">
    <div class="card-header bg-dark text-white">
        <h3 class="card-title">Thống kê sản phẩm theo danh mục</h3>
    </div>
    <div class="card-body">
        <canvas id="productChart" height="80"></canvas>
    </div>
</div>
@stop

@section('css')
<style>
    body { background-color: #181818 !important; color: #fff; }
    .content-wrapper { background: #181818 !important; }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Chuẩn bị dữ liệu PHP → JavaScript
    const chartLabels = {!! json_encode($productChart->pluck('category.name')) !!};
    const chartData   = {!! json_encode($productChart->pluck('total')) !!};

    const ctx = document.getElementById('productChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Số lượng sản phẩm',
                data: chartData,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#20c997']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@stop
