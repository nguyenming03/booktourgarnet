@extends('admin.layouts.app')
@section('style')
    {{-- <!--datatable css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.css') }}" />
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh Sách Thông Báo</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('home-admin') }}">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Danh sách thông báo</li>
                            </ol>
                        </div>

                    </div>
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <a href="{{ route('notifications.create') }}" class="btn btn-secondary"><i
                                    class="bi bi-plus-circle align-baseline me-1"></i> Thêm thông báo</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="coursesList">

                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table id="notification" class="table table-striped" style="width:100%">
                                    <thead class="text-muted">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên thông báo</th>
                                            <th>Nội dung</th>
                                            <th>Tới tất cả người dùng</th>
                                            <th>Loại thông báo</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
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
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // khởi tạo tabe
            let table = $('#notification').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('notifications.index') }}', // Cập nhật với URL đúng
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'content',
                        name: 'content'
                    },
                    {
                        data: 'all_user',
                        name: 'all_user'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format(
                                'YYYY-MM-DD HH:mm:ss'); // Chuyển đổi định dạng ngày tháng
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data, type, row) {
                            return moment(data).format(
                                'YYYY-MM-DD HH:mm:ss'); // Chuyển đổi định dạng ngày tháng
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                    },
                ],
                order: [
                    [0, 'desc']
                ],
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

            // xóa faq

            $('#notification').on('click', '#deleteItem', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Bạn có chắc muốn xóa?',
                    text: "Bạn sẽ không thể hoàn tác sau khi xóa!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('notifications.destroy', ':id') }}".replace(
                                ':id', id),
                            method: "DELETE",
                            dataType: "json",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(res) {
                                if (res.status) {
                                    table.ajax.reload();
                                    Swal.fire('Xóa thành công!', '', 'success');
                                } else {
                                    Swal.fire(res.message, '', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Lỗi AJAX:', error);
                                Swal.fire('Có lỗi xảy ra!', '', 'error');
                            }
                        });
                    }
                })
            });

            // sửa faq

        });
    </script>
@endsection
