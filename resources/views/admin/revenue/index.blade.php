@extends('adminlte::page')

@section('title', 'Báo cáo doanh thu')

@section('content_header')
    <h1>Báo cáo doanh thu</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h4>{{ number_format($totalRevenue) }} đ</h4>
                <p>Tổng doanh thu (Đã giao)</p>
            </div>
            <div class="icon"><i class="fas fa-coins"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h4>{{ number_format($todayRevenue) }} đ</h4>
                <p>Doanh thu hôm nay</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-day"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h4>{{ number_format($monthRevenue) }} đ</h4>
                <p>Doanh thu tháng này</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h4>{{ number_format($totalOrdersDelivered) }}</h4>
                <p>Số đơn đã giao</p>
            </div>
            <div class="icon"><i class="fas fa-truck"></i></div>
        </div>
    </div>
</div>

<div class="card">
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

const ctx = document.getElementById('revChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels,
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
                    callback: function(value){ return value.toLocaleString('vi-VN') + ' đ'; }
                }
            }
        }
    }
});
</script>
@stop
