@extends('adminlte::page')

@section('title', 'Chỉnh sửa Thương hiệu')

@section('content_header')
    <h1>Chỉnh sửa Thương hiệu</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên thương hiệu</label>
                <input type="text" name="name" id="name" class="form-control" 
                    value="{{ $brand->name }}" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                <i class="fas fa-save"></i> Cập nhật
            </button>

            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>

        </form>

    </div>
</div>
@stop
