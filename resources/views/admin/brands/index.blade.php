@extends('adminlte::page')

@section('title', 'Quản lý Thương hiệu')

@section('content_header')
    <h1>Danh sách Thương hiệu</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm thương hiệu
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên thương hiệu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td class="d-flex">

                        <a href="{{ route('admin.brands.edit', $brand->id) }}" 
                           class="btn btn-warning btn-sm mr-2">
                            Sửa
                        </a>

                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Xóa thương hiệu này?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $brands->links('pagination::bootstrap-4') }}
        </div>

    </div>
</div>
@stop
