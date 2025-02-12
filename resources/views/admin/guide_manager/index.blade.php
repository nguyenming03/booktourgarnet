@extends('admin.layouts.app')
@section('title')
    <title>Danh sách hướng dẫn viên | Quản Trị</title>
@endsection
@section('style')
    {{-- <!--datatable css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.css') }}" /> --}}
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh sách hướng dẫn viên đã gán</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home-admin') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Danh sách hướng dẫn viên đã gán</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            {{-- <a href="{{ route('guide_tour.create') }}" class="btn btn-secondary">
                                <i class="bi bi-plus-circle align-baseline me-1"></i> Gán hướng dẫn viên
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="coursesList">
                        {{-- nút thêm faq --}}

                        {{-- end nút thêm faq --}}
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table id="tourguide" class="table table-striped" style="width:100%">
                                    <thead class="text-muted">
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên tour</th>
                                            <th>Hành trình</th>
                                            <th>Số lượng ngày</th>
                                            <th>Nơi khởi hành</th>
                                            <th>Ngày đi</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tourguide">
                                        @php $stt = 1; @endphp
                                        @foreach ($guideTours->tours as $item)
                                            <tr>
                                                <td>{{ $stt++ }}</td>
                                                <td>{{ $item->tour->name ?? 'Chưa cập nhật' }}</td>
                                                <td>{{ $item->tour->schedule ?? 'Chưa cập nhật' }}</td>
                                                <td>{{ $item->tour->duration ?? 'Chưa cập nhật' }} ngày</td>
                                                <td>{{ $item->tour->starting_gate ?? 'Chưa cập nhật' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}</td>
                                                {{-- @php
                                                    // dd($item);
                                                @endphp --}}
                                                {{-- <td>
                                                    @if ($item->pay && $item->pay->status_id != 6)
                                                        <form
                                                            action="{{ route('guide-manager.updateStatusPayment', $item->pay_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH') <!-- Đây là cách gửi phương thức PATCH -->
                                                            <button type="submit" class="btn btn-primary">Xác nhận hoàn
                                                                thành
                                                                tour</button>
                                                        </form>
                                                    @endif
                                                    @if ($item->pay && $item->pay->status_id == 6)
                                                        <button type="submit" class="btn btn-info">Đã hoàn
                                                            thành
                                                            tour</button>
                                                    @endif

                                                </td> --}}
                                                <td>
                                                    <ul class="d-flex gap-2 list-unstyled mb-0">
                                                        {{-- <li>
                                                            <a href="apps-learning-overview.html"
                                                                class="btn btn-subtle-primary btn-icon btn-sm "><i
                                                                    class="ph-eye"></i></a>
                                                        </li> --}}
                                                        <li>
                                                            <a href="{{ route('guide-manager.createguider', $item->id) }}"
                                                                class="btn btn-subtle-success btn-icon btn-sm">
                                                                <i class="ri-edit-2-line"></i></a>
                                                        </li>

                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--datatable js-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $('#tourguide').DataTable({
            language: {
                "sEmptyTable": "Không có dữ liệu trong bảng",
                "sInfo": "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty": "Hiển thị 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(đã lọc từ _MAX_ mục)",
                "sLengthMenu": "Hiển thị _MENU_ mục",
                "sLoadingRecords": "Đang tải...",
                "sProcessing": "Đang xử lý...",
                "sSearch": "Tìm kiếm:",
                "sZeroRecords": "Không tìm thấy kết quả nào",
                "oPaginate": {
                    "sFirst": "Đầu tiên",
                    "sLast": "Cuối cùng",
                    "sNext": "Tiếp theo",
                    "sPrevious": "Trước"
                },
                "oAria": {
                    "sSortAscending": ": kích hoạt để sắp xếp cột theo thứ tự tăng dần",
                    "sSortDescending": ": kích hoạt để sắp xếp cột theo thứ tự giảm dần"
                }
            }
        });
        $('#tourguide').on('click', '#deleteItem', function() {
            let url = $(this).data('url'); // Lấy URL từ data-url
            let row = $(this).closest('tr'); // Lấy dòng cần xóa

            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                text: "Bạn sẽ không thể hoàn tác sau khi xóa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: "DELETE",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}" // CSRF token
                        },
                        success: function(res) {
                            if (res.status) {
                                // Xóa dòng khỏi bảng
                                $(row).remove();
                                Swal.fire('Xóa thành công!', '', 'success');
                            } else {
                                Swal.fire(res.message || 'Xóa thất bại!', '', 'error');
                            }
                        },
                        error: function(xhr) {
                            console.error('Lỗi AJAX:', xhr.responseText);
                            Swal.fire('Có lỗi xảy ra!', xhr.responseJSON?.message ||
                                'Vui lòng thử lại.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
