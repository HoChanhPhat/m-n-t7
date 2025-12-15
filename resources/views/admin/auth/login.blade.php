@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_body')

@if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif
<form method="POST" action="{{ route('admin.login.submit') }}">



    @csrf

    <div class="input-group mb-3">
        <input name="email" type="email" class="form-control" required placeholder="Email admin">
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
        </div>
    </div>

    <div class="input-group mb-3">
        <input name="password" type="password" class="form-control" required placeholder="Mật khẩu">
        <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
</form>

@endsection
