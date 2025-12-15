@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4>Đăng ký tài khoản</h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <label class="mt-2">Họ và tên</label>
                    <input type="text" name="name" class="form-control" required>

                    <label class="mt-2">Email</label>
                    <input type="email" name="email" class="form-control" required>

                    <label class="mt-2">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>

                    <label class="mt-2">Nhập lại mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control" required>

                    <button class="btn btn-primary w-100 mt-3">Đăng ký</button>

                    <p class="text-center mt-3">
                        Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
                    </p>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
