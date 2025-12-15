@extends('adminlte::page')

@section('title', 'Thêm Thương hiệu')

@section('content_header')
    <h1>Thêm Thương hiệu</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.brands.store') }}" method="POST">
            @csrf

            {{-- Tên thương hiệu --}}
            <div class="form-group">
                <label for="name">Tên thương hiệu</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            {{-- Danh mục --}}
            <div class="form-group mt-3">
                <label for="category_id">Danh mục</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">
                <i class="fas fa-save"></i> Lưu
            </button>

            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>

        </form>

    </div>
</div>
@stop
