@extends('adminlte::page')

@section('title', 'Mã giảm giá')

@section('content_header')
    <h1>Mã giảm giá</h1>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.coupons.create')
 }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tạo mã mới
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách mã giảm giá</h3>
        </div>

        <div class="card-body">
            @if($coupons->count() == 0)
                <p>Chưa có mã giảm giá nào.</p>
            @else
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Đã dùng</th>
                            <th>Giới hạn</th>
                            <th>Trạng thái</th>
                            <th>Ngày hết hạn</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td>{{ $c->code }}</td>
                                <td>{{ $c->type }}</td>
                                <td>{{ $c->value }}</td>
                                <td>{{ $c->used }}</td>
                                <td>{{ $c->limit == 0 ? 'Không giới hạn' : $c->limit }}</td>
                                <td>
                                    @if($c->is_active)
                                        <span class="badge bg-success">Bật</span>
                                    @else
                                        <span class="badge bg-danger">Tắt</span>
                                    @endif
                                </td>
                                <td>{{ $c->end_date ? $c->end_date->format('d/m/Y') : 'Không' }}</td>

                                <td class="d-flex justify-content-center">
                                    
                                    {{-- Bật / Tắt --}}
                                    <form action="{{ route('admin.coupons.toggle', $c->id) }}" method="POST" class="me-2">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">
                                            {{ $c->is_active ? 'Tắt' : 'Bật' }}
                                        </button>
                                    </form>

                                    {{-- Sửa --}}
                                    <a href="{{ route('admin.coupons.edit', $c->id) }}"
                                       class="btn btn-info btn-sm me-2">Sửa</a>

                                    {{-- Xóa --}}
                                    <form action="{{ route('admin.coupons.destroy', $c->id) }}" method="POST"
                                          onsubmit="return confirm('Xóa mã này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Xóa</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop
