@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h3 class="mb-4 fw-bold">Thông tin cá nhân</h3>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        {{-- ================= LEFT: Thông tin cá nhân ================= --}}
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Cập nhật thông tin
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('account.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="VD: 0901234567">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
    <label class="form-label">Địa chỉ giao hàng</label>
    <textarea name="shipping_address"
              class="form-control"
              rows="3"
              placeholder="Nhập địa chỉ nhận hàng...">{{ old('shipping_address', $user->shipping_address) }}</textarea>

    @error('shipping_address')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                        <button class="btn btn-primary">
                            Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ================= RIGHT: Tài khoản + Đổi mật khẩu ================= --}}
        <div class="col-md-5">

            {{-- Thông tin nhanh --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-semibold">
                    Thông tin tài khoản
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <span class="text-muted">Email:</span><br>
                        <strong>{{ $user->email }}</strong>
                    </p>
                    <p class="mb-2">
                        <span class="text-muted">Họ tên:</span><br>
                        <strong>{{ $user->name }}</strong>
                    </p>
                    <p class="mb-0">
                        <span class="text-muted">Số điện thoại:</span><br>
                        <strong>{{ $user->phone ?? 'Chưa cập nhật' }}</strong>
                    </p>
                </div>
            </div>

            {{-- Đổi mật khẩu --}}
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Đổi mật khẩu
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('account.changePassword') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="form-control">
                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control">
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>

                        <button class="btn btn-dark w-100">
                            Cập nhật mật khẩu
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
