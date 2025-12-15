@extends('adminlte::page')

@section('title', 'Tạo mã giảm giá')

@section('content_header')
    <h1>Tạo mã giảm giá</h1>
@stop

@section('content')
    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Mã giảm giá</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Loại</label>
            <select name="type" class="form-control">
                <option value="percent">Percentage (%)</option>
                <option value="fixed">Fixed Amount</option>
            </select>
        </div>

        <div class="form-group">
    <label>Đối tượng áp dụng</label>
    <select name="target_user" class="form-control">
        <option value="all">Tất cả người dùng</option>
        <option value="new_user">Chỉ người mới</option>
    </select>
</div>


        <div class="form-group">
            <label>Giá trị giảm</label>
            <input type="number" name="value" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Giới hạn sử dụng (0 = Không giới hạn)</label>
            <input type="number" name="limit" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="form-group">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="form-group mt-3">
            <label>
                <input type="checkbox" name="is_active" value="1"> Kích hoạt mã
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@stop
