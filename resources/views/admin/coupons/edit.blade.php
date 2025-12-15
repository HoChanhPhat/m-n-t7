@extends('adminlte::page')

@section('title', 'Chỉnh sửa mã giảm giá')

@section('content_header')
    <h1>Chỉnh sửa mã giảm giá</h1>
@stop

@section('content')
    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Mã giảm giá</label>
            <input type="text" name="code" class="form-control"
                   value="{{ $coupon->code }}" required>
        </div>

        <div class="form-group">
            <label>Loại</label>
            <select name="type" class="form-control">
                <option value="percent" {{ $coupon->type=='percent'?'selected':'' }}>Percentage (%)</option>
                <option value="fixed" {{ $coupon->type=='fixed'?'selected':'' }}>Fixed Amount</option>
            </select>
        </div>

        <div class="form-group">
            <label>Giá trị giảm</label>
            <input type="number" name="value" class="form-control"
                   value="{{ $coupon->value }}" required>
        </div>

        <div class="form-group">
            <label>Giới hạn sử dụng (0 = Không giới hạn)</label>
            <input type="number" name="limit" class="form-control"
                   value="{{ $coupon->limit }}">
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control"
                   value="{{ $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '' }}">
        </div>

        <div class="form-group">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control"
                   value="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '' }}">
        </div>

        <div class="form-group mt-3">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                Kích hoạt mã
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@stop
