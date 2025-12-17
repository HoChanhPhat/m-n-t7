@extends('adminlte::page')

@section('title', 'Đổi mật khẩu')

@section('content_header')
    <h1>Đổi mật khẩu</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        @if (session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf

            <div class="form-group">
                <label>Mật khẩu hiện tại</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Mật khẩu mới</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group mt-2">
                <label>Xác nhận mật khẩu mới</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-primary mt-3">Cập nhật</button>
        </form>
    </div>
</div>
@stop
