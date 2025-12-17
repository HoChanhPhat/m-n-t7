@extends('adminlte::page')

@section('title', 'Báo cáo doanh thu')

@section('content_header')
    <h1>Báo cáo doanh thu</h1>
@stop

@section('content')

    {{-- 4 ô thống kê --}}
    <div class="row">

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h4>{{ number_format($totalRevenue) }} đ</h4>
                    <p>Tổng doanh thu (Đã giao)</p>
                </div>
                <div class="icon"><i class="fas fa-coins"></i></div>

                <a href="{{ route('admin.revenue.details', 'total') }}" class="small-box-footer">
                    Xem sản phẩm đã giao <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>{{ number_format($todayRevenue) }} đ</h4>
                    <p>Doanh thu hôm nay</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-day"></i></div>

                <a href="{{ route('admin.revenue.details', 'today') }}" class="small-box-footer">
                    Xem sản phẩm đã giao hôm nay <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h4>{{ number_format($monthRevenue) }} đ</h4>
                    <p>Doanh thu tháng này</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>

                <a href="{{ route('admin.revenue.details', 'month') }}" class="small-box-footer">
                    Xem sản phẩm đã giao tháng này <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h4>{{ number_format($totalOrdersDelivered) }}</h4>
                    <p>Số đơn đã giao</p>
                </div>
                <div class="icon"><i class="fas fa-truck"></i></div>

                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">
                    Xem danh sách đơn <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>

    {{-- Biểu đồ --}}
    <div class="card mt-3">
        <div class="card-header">
            <b>Doanh thu 7 ngày gần nhất</b>
        </div>
        <div class="card-body">
            <canvas id="revChart" height="90"></canvas>
        </div>
    </div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const values = @json($values);

        const canvas = document.getElementById('revChart');

        // Nếu vì lý do nào đó canvas chưa render, tránh crash JS
        if (canvas) {
            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Doanh thu (đ)',
                        data: values,
                        tension: 0.35,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: true } },
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('vi-VN') + ' đ';
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@stop
