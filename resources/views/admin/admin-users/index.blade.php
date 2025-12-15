@extends('adminlte::page')

@section('title','Quản lý Admin')

@section('content_header')
<h1>Quản lý Admin</h1>
@stop

@section('content')

<a href="{{ route('manage.create') }}" class="btn btn-primary mb-3">
    + Tạo Admin phụ
</a>

<div class="card">
<div class="card-body">

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Tên</th><th>Email</th><th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admins as $a)
        <tr>
            <td>{{ $a->id }}</td>
            <td>{{ $a->name }}</td>
            <td>{{ $a->email }}</td>
            <td>{{ $a->role }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $admins->links() }}

</div>
</div>

@stop
