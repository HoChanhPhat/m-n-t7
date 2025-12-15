@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow">
            <div class="card-header bg-dark text-white text-center">
                <h4>Đăng nhập</h4>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

              <form action="{{ route('login') }}" method="POST">

                    @csrf

                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>

                    <label class="mt-2">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>

                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>

                    <button class="btn btn-dark w-100 mt-3">Đăng nhập</button>

                    <p class="text-center mt-3">
                        Chưa có tài khoản? <a href="{{ route('register') }}">Tạo ngay</a>
                    </p>
                    <a href="{{ route('google.redirect') }}" class="btn btn-danger w-100 mt-3">
    <i class="bi bi-google"></i> Đăng nhập bằng Google
</a>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
