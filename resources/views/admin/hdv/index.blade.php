@extends('admin.layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h1>Danh sách hướng dẫn viên</h1>

            @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

            

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Quyền hiện tại</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->guide_id ? 'Hướng dẫn viên' : 'Người dùng' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if(!$user->guide_id)
                                        <form action="{{ route('hdv.assignGuide', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">Gán quyền hướng dẫn viên</button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">Đã là hướng dẫn viên</span>
                                        <form action="{{ route('hdv.revokeGuide', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Hủy quyền hướng dẫn viên</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
