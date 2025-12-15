@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h3 class="mb-4">Thông tin cá nhân</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('account.update') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ $user->phone }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ giao hàng</label>
            <textarea name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
        </div>

        <button class="btn btn-primary">Lưu thay đổi</button>

    </form>
</div>
@endsection
