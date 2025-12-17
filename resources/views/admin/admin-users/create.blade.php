@extends('adminlte::page')

@section('title','Tạo Admin phụ')

@section('content_header')
<h1>Tạo Admin phụ</h1>
@stop

@section('content')
<div class="card">
  <div class="card-body">
    <form action="{{ route('admin.manage.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label>Tên</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="form-group mt-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="form-group mt-2">
        <label>Mật khẩu</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.manage.index') }}" class="btn btn-secondary">Quay lại</a>
      </div>
    </form>
  </div>
</div>
@stop
