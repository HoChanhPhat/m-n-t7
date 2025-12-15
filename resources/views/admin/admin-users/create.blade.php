@extends('adminlte::page')

@section('title','Tạo Admin phụ')

@section('content_header')
<h1>Tạo Admin phụ</h1>
@stop

@section('content')

<div class="card">
<div class="card-body">
<form action="{{ route('manage.store') }}" method="POST">

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

    <button class="btn btn-success mt-3">Lưu</button>
  <a href="{{ route('manage.create') }}" class="btn btn-primary mb-3">
</form>

</div>
</div>

@stop
