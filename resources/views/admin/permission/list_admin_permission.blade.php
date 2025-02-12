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
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="coursesList">
                        {{-- nút thêm faq --}}
                        <a href="{{ route('notification-user.create') }}" class="btn btn-secondary col-2"><i
                                class="bi bi-plus-circle align-baseline me-1"></i> Gán thông báo</a>
                        {{-- end nút thêm faq --}}
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table id="permission_user" class="table table-striped" style="width:100%">
                                    <thead class="text-muted">
                                        <tr>

                                            <th>STT</th>

                                            <th>Tên người quản trị</th>

                                            <th>Tên quyền</th>

                                            <th>Ngày gán</th>

                                            <th>Ngày cập nhật</th>

                                            <th>Hành động</th>
                                        </tr>
                                    </thead>

                                </table><!-- end table -->

                            </div>
                            <!--end row-->
                        </div>
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->
            {{-- @include('admin.faq.delete') --}}
            {{-- @include('admin.faq.edit')
            @include('admin.faq.add') --}}


        </div>
        <!-- container-fluid -->


    </div>
@endsection


@section('script')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // khởi tạo table
            var route = "{{ route('permission-user.index') }}"
            let table = $('#permission_user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: route, // Cập nhật với URL đúng
                    type: 'GET'
                },
                columns: [{
                        data: null, // Sử dụng null vì bạn sẽ tạo số thứ tự theo index
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Meta.row sẽ trả về chỉ số của dòng trong bảng
                        },
                        name: 'stt' // Đặt tên cho cột để dễ nhận diện (tùy chọn)
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'permission_name',
                        name: 'permission_name'
                    },

                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format(
                                'YYYY-MM-DD HH:mm:ss'); // Chuyển đổi định dạng ngày tháng
                        }
                    }, // Ngày gán
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data, type, row) {
                            return moment(data).format(
                                'YYYY-MM-DD HH:mm:ss'); // Chuyển đổi định dạng ngày tháng
                        }
                    }, // Ngày cập nhật
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    } // Các hành động như Xóa
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

            $('#permission_user').on('click', '#deleteItem', function() {
                let userId = $(this).data('user-id');
                let permissionId = $(this).data('permission-id');

                if (userId && permissionId) {
                    console.log('User ID:', userId, 'Permission ID:', permissionId); // Debug
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
                                url: "{{ route('per-user.destroy') }}", // Cập nhật đúng route
                                method: "DELETE",
                                dataType: "json",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    user_id: userId,
                                    permission_id: permissionId
                                },
                                success: function(res) {
                                    if (res.status) {
                                        $('#permission_user').DataTable().ajax.reload();
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
                    });
                } else {
                    console.error('Không lấy được User ID hoặc Permission ID');
                }
            });


            // sửa faq

        });
    </script>
@endsection
