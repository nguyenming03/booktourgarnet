@extends('admin.layouts.app')

@section('style')
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh Sách Các Tour Yêu Cầu Hoàn Tiền</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                <li class="breadcrumb-item active">Danh Sách Các Tour Yêu Cầu Hoàn Tiền</li>
                            </ol>
                        </div>

                    </div>
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('user.cancellationHistories') }}" class="btn btn-secondary"><i
                                        ></i> Lịch sử các tour hoàn / hủy</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="coursesList">
                        <div class="card-body">
                            <div class="row align-items-center g-2">
                                <div class="col-lg-3 me-auto">

                                </div><!--end col-->
                                <div class="col-lg-2">
                                    <div class="search-box">

                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-auto">
                                    <div class="hstack flex-wrap gap-2">
                                        <button class="btn btn-subtle-danger d-none" id="remove-actions"
                                            onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>

                                        <div>


                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table id="example" class="table table-striped" style="width:100%">
                                    <thead class="text-muted">
                                        <tr>

                                            <th>Số thứ tự</th>
                                            <th>Tài Khoản Đặt Tour</th>
                                            <th>Thông Tin Tour</th>
                                            <th>Lý Do Hủy</th>
                                            <th>Số Tiền Hoàn</th>
                                            <th>Hành động</th>




                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($listTour as $index => $item)
                                            <tr>


                                                <td><a href="" class="text-reset">{{ $item->id }}</a></td>

                                                <td>{{ $item->booking->user->name ?? 'Ẩn Danh' }}</td>
                                                <td>{{ $item->booking->tour->name ?? 'Tour đã bị xóa' }}</td>
                                                <td>{{ $item->booking->ly_do_huy }} </td>

                                                <td> {{ number_format($item->refund_amount, 0, ',', '.') }} vnd</td>

                                                {{-- <td class="{{ $item->status == 1 ? 'text-success' : 'text-danger' }}">
                                                {{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}</td> --}}
                                                <td>
                                                    <ul class="d-flex gap-2 list-unstyled mb-0">


                                                        <li>
                                                            <a href="#deleteRecordModal{{ $item->id }}"
                                                                data-bs-toggle="modal"
                                                                class="btn btn-subtle-success btn-icon btn-sm remove-item-btn">
                                                                <i class="ph-check-circle"></i>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#view{{ $item->id }}" data-bs-toggle="modal"
                                                                class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"><i
                                                                    class="ph-eye"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#khongchohuy{{ $item->id }}" data-bs-toggle="modal"
                                                                class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"><i
                                                                    class="ph-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <!-- Xóa User -->
                                            <div id="deleteRecordModal{{ $item->id }}" class="modal fade zoomIn"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" id="deleteRecord-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-md-5">
                                                            <div class="text-center">
                                                                <h1>Tải Lên Minh Chứng Cho Khách Hàng </h1>

                                                            </div>
                                                            <form action="{{ route('user.uploadCancelProof', $item->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="form-group mt-3">
                                                                    <label for="cancel_proof_image">Tải lên ảnh minh
                                                                        chứng:</label>
                                                                    <input type="file" name="cancel_proof_image"
                                                                        id="cancel_proof_image" accept="image/*" required
                                                                        class="form-control">
                                                                </div>
                                                                <div class="form-group mt-3">
                                                                    <label for="confirmation_code">Mã xác nhận:</label>
                                                                    <input type="text" name="confirmation_code"
                                                                        id="confirmation_code"
                                                                        placeholder="Nhập mã xác nhận" required
                                                                        class="form-control">
                                                                </div>
                                                                <div
                                                                    class="d-flex gap-2 justify-content-center mt-4 pt-2 mb-2">
                                                                    <button type="button"
                                                                        class="btn w-sm btn-light btn-hover"
                                                                        data-bs-dismiss="modal">Đóng</button>
                                                                    <button type="submit"
                                                                        class="btn w-sm btn-primary btn-hover">Gửi</button>
                                                                </div>
                                                            </form>


                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>
                                            <div id="khongchohuy{{ $item->id }}" class="modal fade zoomIn"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" id="closeModal"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-md-5">
                                                            <div class="text-center">
                                                                <div class="text-warning">
                                                                    <i class="bi bi-exclamation-circle display-5"></i>
                                                                </div>
                                                               
                                                                <div class="mt-4">
                                                                    <h4 class="mb-2">Bạn có chắc không cho khách hàng hủy
                                                                        tour?</h4>
                                                                    <p class="text-muted mx-3 mb-0">Nếu đồng ý, trạng thái
                                                                        sẽ được đặt lại và khách hàng không thể hủy tour.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-column align-items-center mt-4 pt-2 mb-2">
                                                                <form action="{{ route('user.rejectCancel', $item->id) }}" method="POST" class="w-100">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group mb-3">
                                                                        <label for="admin_comment" class="form-label">Lý do từ chối khách hàng:</label>
                                                                        <textarea name="admin_comment" id="admin_comment" rows="4" 
                                                                            placeholder="Nhập lý do từ chối" required 
                                                                            class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between mt-3">
                                                                        <button type="button" class="btn btn-light btn-hover" data-bs-dismiss="modal">
                                                                            Đóng
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary btn-hover" id="confirm-reject">
                                                                            Đồng ý
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="view{{ $item->id }}" class="modal fade zoomIn" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Chi tiết thông tin hoàn tiền</h5>
                                                            <button type="button" class="btn-close"
                                                                id="deleteRecord-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-md-5">
                                                            <div class="text-center">
                                                                <h4 class="mb-4"></h4>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Ảnh QR:</label>
                                                                <div>
                                                                    @if ($item->booking->qr_code)
                                                                        <img src="{{ asset('storage/' . $item->booking->qr_code) }}"
                                                                            alt="Minh chứng" class="img-fluid rounded"
                                                                            style="max-height: 200px;">
                                                                    @else
                                                                        <p class="text-muted">Chưa có ảnh QR.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Số Tài Khoản:</label>
                                                                <p class="text-muted">
                                                                    {{ $item->booking->account_number ?? 'Chưa có số tài khoản.' }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Tên Tài Khoản:</label>
                                                                <p class="text-muted">
                                                                    {{ $item->booking->account_name ?? 'Chưa có tên.' }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Số Tiền Hoàn:</label>
                                                                <p class="text-muted">
                                                                    {{ number_format($item->refund_amount, 0, ',', '.') }}VND
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Ngân Hàng:</label>
                                                                <p class="text-muted">
                                                                    {{ $item->booking->bank ?? 'Chưa có tên.' }}
                                                                </p>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>
                                        @endforeach
                                    </tbody><!-- end tbody -->
                                </table><!-- end table -->
                                <div class="noresult" style="display: none">
                                    <div class="text-center py-4">
                                        <i class="ph-magnifying-glass fs-1 text-primary"></i>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Courses We did not find
                                            any Courses for you search.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-4 pt-2" id="pagination-element">
                                <div class="col-sm">
                                    <div class="text-muted text-center text-sm-start">
                                        Showing <span class="fw-semibold">10</span> of <span class="fw-semibold">15</span>
                                        Results
                                    </div>
                                </div><!--end col-->
                                <div class="col-sm-auto mt-3 mt-sm-0">
                                    <div class="pagination-wrap hstack gap-2 justify-content-center">
                                        <a class="page-item pagination-prev disabled" href="javascript:void(0)">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="javascript:void(0)">
                                            Next
                                        </a>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->




        </div>
        <!-- container-fluid -->


    </div>
@endsection
@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
@endsection
@section('script-libs')
    <!--datatable js-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $('#example').DataTable({
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
    </script>
@endsection
@section('script')

@section('script')
    <script>
        $(document).ready(function() {
            // thêm faq
            $('#addCouponsForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn submit mặc định của form

                // Xóa thông báo lỗi cũ
                $('#question-error').text('');
                $('#answer-error').text('');
                $('#status-error').text('');

                $.ajax({
                    url: "{{ route('coupons.store') }}", // URL action của form
                    type: 'POST',
                    data: $(this).serialize(), // Lấy dữ liệu từ form và bao gồm CSRF token
                    success: function(response) {
                        // Xử lý khi request thành công (có thể đóng modal, load lại danh sách FAQ)
                        // $('#addFaq').modal('hide');
                        // alert('Câu hỏi đã được thêm thành công!');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        // Xử lý khi request bị lỗi
                        if (xhr.status === 422) { // Lỗi xác thực
                            let errors = xhr.responseJSON.errors;
                            if (errors.question) {
                                $('#question-error').text(errors.question[0]);
                            }
                            if (errors.answer) {
                                $('#answer-error').text(errors.answer[0]);
                            }
                            if (errors.status_id) {
                                $('#status-error').text(errors.status_id[0]);
                            }
                        } else {
                            console.log("Có lỗi xảy ra:", xhr.responseText);
                        }
                    }
                });
            });

            // xóa faq

            $('.remove-item-btn').on('click', function() {
                // Lấy ID của item cần xóa từ thuộc tính data-id
                const itemId = $(this).data('id');
                const url = "{{ route('coupons.destroy', ':id') }}"; // Tạo URL với placeholder :id
                const deleteUrl = url.replace(':id', itemId); // Thay thế :id bằng itemId
                $('#deleteForm').attr('action', deleteUrl); // Cập nhật action của form xóa 
            });
        });
    </script>
@endsection
