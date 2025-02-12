@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Lịch sử hủy</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên tour</th>
                <th>Khách hàng</th>
                <th>Trạng thái</th>
                <th>Ngày yêu cầu</th>
                <th>Lý do từ chối</th>
                <th>Người xử lý</th>
                <th>Ảnh minh chứng</th>
                <th>Mã minh chứng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cancellationHistories as $history)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $history->booking->tour->name ?? 'N/A' }}</td>
                    <td>{{ $history->booking->user->name ?? 'N/A' }}</td>
                    <td>
                        @if ($history->status == 1)
                            <span class="text-success">Đã duyệt</span>
                        @else
                            <span class="text-danger">Từ chối</span>
                        @endif
                    </td>
                    <td>{{ $history->requested_at }}</td>
                    <td>{{ $history->admin_comment ?? 'Không có' }}</td>
                    <td>{{ $history->processed_by ? 'Admin #' . $history->processed_by : 'Không xác định' }}</td>
                    <td>
                        @if ($history->proof_image)
                            <a href="{{ asset('storage/' . $history->proof_image) }}" target="_blank">Xem ảnh</a>
                        @else
                            Không có
                        @endif
                    </td>
                    <td>{{ $history->proof_code ?? 'Không có' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
