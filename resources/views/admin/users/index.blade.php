@extends('adminlte::page')

@section('title', 'Quản lý khách hàng')

@section('content_header')
    <h1>Quản lý khách hàng</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-hover">
            <thead class="bg-dark text-white">
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Đã khóa</span>
                        @endif
                    </td>

                    <td>
                        <form method="POST" action="{{ route('users.toggle', $user->id) }}">
                            @csrf
                            <button class="btn btn-warning btn-sm">
                                {{ $user->is_active ? 'Khóa' : 'Mở khóa' }}
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}

    </div>
</div>
@endsection
