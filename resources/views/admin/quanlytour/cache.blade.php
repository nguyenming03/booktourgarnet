@extends('admin.layouts.app')

@section('style')
    <style>
        .status-tour {
            width: 100%;
            padding: 10px;

            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: #333;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        .status-tour:hover {
            border-color: #025fc9;
            background-color: #e9f7ff;
        }

        .status-tour:focus {
            border-color: #007bff;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .status-tour option {
            padding: 10px;
            font-size: 16px;
            background-color: #fff;
            color: #333;
        }

        .status-tour option:checked {
            background-color: #007bff;
            color: white;
        }

        #search-form-container.hidden {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        #search-form-container.show {
            max-height: 500px;
            transition: max-height 0.3s ease;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh sách đơn hàng</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Trang Chủ</a></li>
                                <li class="breadcrumb-item active">Danh sách đơn hàng</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row g-3 mb-3 justify-content-sm-end justify-center">
                        <div class="col-auto">
                            <div class="row">
                                <div class="col-auto">

                                    <div id="search-form-container" class="hidden">
                                        <form action="{{ route('payment_tour.index') }}" method="GET" id="search-form">
                                            <div class="d-flex gap-3 justify-content-sm-end">
                                                <div class="form-group">
                                                    <label for="start_date">Từ ngày:</label>
                                                    <input type="date" name="start_date" id="start_date"
                                                        style="width: 280px" value="{{ request('start_date') }}"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="end_date">Đến ngày:</label>
                                                    <input type="date" name="end_date" id="end_date"style="width: 280px"
                                                        value="{{ request('end_date') }}" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-4" style="top: -5px">Tìm
                                                    kiếm</button>
                                            </div>
                                        </form>

                                        <div class="d-flex justify-content-end">
                                            <form id="filter-form" action="{{ route('admin.quanlytour.filter') }}"
                                                method="GET">
                                                <div class="form-group d-flex gap-2">
                                                    <select name="payment_status_id" id="payment_status_id"
                                                        class="form-control" style="width: 245px">
                                                        <option value="">Tất cả trạng thái thanh toán</option>
                                                       
                                                    </select>
                                                    <select name="status_id" id="status_id" class="form-control"
                                                        style="width: 220px">
                                                        <option value="">Tất cả trạng thái</option>
                                                        
                                                    </select>
                                                    <input type="text" id="searchInput" name="search"
                                                        placeholder="Search..." class="form-control" style="width: 200px">
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-sm-end">
                                        <button id="toggleSearchBtn" class="btn btn-secondary mt-3" style="width: 200px">Tìm
                                            kiếm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="coursesList">
                    <div class="card-body">
                        <div class="table-responsive table-card">
                          <table id="example-tour-table" class="table table-striped" style="width:100%">
                            <thead class="text-muted">
                                <tr>
                                    <th>Số thứ tự</th>
                                    <th>Tài Khoản Đặt Tour</th>
                                    <th>Thông Tin Tour</th>
                                    <th>Lý Do Hủy</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all" id="tour-table-body">
                                @if ($listTour->isEmpty())
                                    <tr>
                                        <td colspan="11" class="text-center text-muted">Trống.</td>
                                    </tr>
                                @else
                                    @foreach ($listTour as $index => $item)
                                        <tr>
                                            <td><a href="" class="text-reset">{{ $item->id }}</a></td>
                                            <td>{{ $item->booking->user->name ?? 'Ẩn Danh' }}</td>
                                            <td>{{ $item->booking->tour->name ?? 'Tour đã bị xóa' }}</td>
                                            <td>{{ $item->booking->ly_do_huy }}</td>
                                            <td>
                                                <ul class="d-flex gap-2 list-unstyled mb-0">
                                                    <li>
                                                        <!-- Nút Chấp Nhận Hủy -->
                                                        <form action="{{ route('user.acceptCancel', $item->id) }}" method="POST" id="acceptCancelForm{{ $item->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#uploadCancelProofModal{{ $item->id }}">Chấp nhận hủy</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <!-- Nút Không Chấp Nhận -->
                                                        <form action="{{ route('user.rejectCancel', $item->id) }}" method="POST" id="rejectCancelForm{{ $item->id }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger" onclick="handleRejectCancel({{ $item->id }})">Không chấp nhận</button>
                                                        </form>

                                                    </li>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                                                      Launch static backdrop modal
                                                    </button>
                                                    
                                                </ul>
                                            </td>
                                        </tr>
                        
                                        <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="staticBackdropLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
                        
                                        <script>
                                            function handleRejectCancel(id) {
                                                if (!confirm('Bạn có chắc chắn không chấp nhận hủy không?')) {
                                                    event.preventDefault();
                                                }
                                            }
                                        </script>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        
                            <div class="noresult" style="display: none">
                                <div class="text-center py-4">
                                    <i class="ph-magnifying-glass fs-1 text-primary"></i>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ Courses We did not
                                        find
                                        any Courses for you search.</p>
                                </div>
                            </div>

                        </div>

                        <div class="row align-items-center mt-4 pt-3" id="pagination-element"
                            style="width: 100%; overflow: hidden;">
                            <div class="col-sm">
                                <div class="text-muted text-center text-sm-start">
                                    Hiển thị <span class="fw-semibold">{{ $listTour->count() }}</span> trên <span
                                        class="fw-semibold">{{ $listTour->total() }}</span> Kết quả
                                </div>
                            </div>

                            <div class="col-sm-auto mt-3 mt-sm-0">
                                <div class="pagination-wrap hstack justify-content-center gap-2">
                                    @if ($listTour->onFirstPage())
                                        <a class="page-item pagination-prev disabled" href="#">Trước</a>
                                    @else
                                        <a class="page-item pagination-prev"
                                            href="{{ $listTour->previousPageUrl() }}">Trước</a>
                                    @endif

                                    <ul class="pagination listjs-pagination mb-0">
                                        @foreach ($listTour->getUrlRange(1, $listTour->lastPage()) as $page => $url)
                                            <li class="{{ $listTour->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page" href="{{ $url }}"
                                                    data-i="{{ $page }}"
                                                    data-page="{{ $page }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    @if ($listTour->hasMorePages())
                                        <a class="page-item pagination-next" href="{{ $listTour->nextPageUrl() }}">Tiếp
                                            theo</a>
                                    @else
                                        <a class="page-item pagination-next disabled" href="#">Tiếp theo</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="quanlytourDetailModal" tabindex="-1" aria-labelledby="quanlytourDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quanlytourDetailModalLabel">Chi Tiết Thông Tin Hủy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="quanlytourDetailContent">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
@endsection
@section('script')
    <script>
        document.getElementById('toggleSearchBtn').addEventListener('click', function() {
            var searchFormContainer = document.getElementById('search-form-container');
            var paginationElement = document.getElementById('pagination-element');

            if (searchFormContainer.classList.contains('hidden')) {
                searchFormContainer.classList.remove('hidden');
                this.textContent = 'Đóng tìm kiếm';
            } else {
                searchFormContainer.classList.add('hidden');
                this.textContent = 'Tìm kiếm';
            }


            if (searchFormContainer.classList.contains('hidden')) {
                paginationElement.style.display = 'block';
            } else {
                paginationElement.style.display = 'none';
            }
        });

        document.getElementById('search-form').addEventListener('submit', function() {
            var paginationElement = document.getElementById('pagination-element');
            paginationElement.style.display = 'none'; // Hide pagination on form submit
        });
    </script>
    {{-- <script>
        document.getElementById('toggleSearchBtn').addEventListener('click', function() {
            var searchFormContainer = document.getElementById('search-form-container');

            if (searchFormContainer.classList.contains('hidden')) {
                searchFormContainer.classList.remove('hidden')
                this.textContent = 'Đóng tìm kiếm';
            } else {
                searchFormContainer.classList.add('hidden');
                this.textContent = 'Tìm kiếm';
            }
        });
    </script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js">
        < /scrip> <
        script src = "https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js" >
    </script>
    <script>
        document.getElementById('searchInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            function updateStatus(url, data, selectElement, defaultValue) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Trạng thái cập nhật thành công!',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                            });

                            if (response.disabled) {
                                selectElement.prop('disabled', true);
                            }

                            selectElement.val(response.new_status);

                            if (response.new_status == 6) {
                                selectElement.prop('disabled', true);
                                selectElement.closest('form').find('button[type="submit"]')
                                    .prop('disabled', true);
                            }
                        } else {
                            Swal.fire(
                                'Lỗi!',
                                response.message,
                                'error'
                            );
                            selectElement.val(defaultValue);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr, status, error);
                        Swal.fire(
                            'Lỗi!',
                            'Có lỗi xảy ra khi cập nhật trạng thái.',
                            'error'
                        );
                        selectElement.val(defaultValue);
                    }
                });
            }

            var isSearchingOrFiltering = $('#status_id').length > 0 || $('#payment_status_id').length > 0 || $(
                '#searchInput').length > 0;

            $(document).on('change', '.payment-status-select', function() {
                var selectElement = $(this);
                var tourId = selectElement.data('id');
                var paymentStatusId = selectElement.val();
                var defaultPaymentStatusId = selectElement.data('default-value');


                Swal.fire({
                    title: 'Bạn có chắc chắn muốn thay đổi trạng thái?',
                    // text: "Trạng thái sẽ được cập nhật!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, thay đổi',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'payment_status_id': paymentStatusId
                        };
                        var url = '/admin/trangthaitour/updateThanhToan/' + tourId;
                        updateStatus(url, data, selectElement, defaultPaymentStatusId);
                    } else {
                        selectElement.val(defaultPaymentStatusId);
                    }
                });
            });


            $(document).on('change', '.status', function() {
                var selectElement = $(this);
                var tourId = selectElement.data('id');
                var statusId = selectElement.val();
                var defaultStatusId = selectElement.data('default-value');

                Swal.fire({
                    title: 'Bạn có chắc chắn muốn thay đổi trạng thái?',
                    // text: "Trạng thái sẽ được cập nhật!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có, thay đổi',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'status_id': statusId
                        };
                        var url = '/admin/trangthaitour/update/' + tourId;
                        updateStatus(url, data, selectElement, defaultStatusId);
                    } else {
                        selectElement.val(defaultStatusId);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchQuery = document.getElementById("searchInput");
            const statusFilter = document.getElementById('status_id');
            const paymentFilter = document.getElementById('payment_status_id');
            const tourTableBody = document.getElementById('tour-table-body');

            function fetchFilteredTours() {
                const statusId = statusFilter.value;
                const paymentId = paymentFilter.value;
                const searchQueryValue = searchQuery.value;

                console.log('Status ID:', statusId);
                console.log('Payment ID:', paymentId);
                console.log('Search Query:', searchQueryValue);

                fetch(`{{ route('admin.quanlytour.filter') }}?status_id=${statusId}&payment_status_id=${paymentId}&search=${searchQueryValue}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then((data) => {
                        tourTableBody.innerHTML = data.html;
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }

            // Event listeners for filters and search
            statusFilter.addEventListener('change', fetchFilteredTours);
            paymentFilter.addEventListener('change', fetchFilteredTours);
            searchQuery.addEventListener('input', fetchFilteredTours);
        });
    </script>
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

    <script>
        $(document).ready(function() {

            $('.view-quanlytour').on('click', function(e) {
                e.preventDefault();

                const quanlytourId = $(this).data('id');

                $.ajax({
                    url: '/admin/xu-ly-huy/' +
                        quanlytourId,
                    type: 'GET',
                    success: function(response) {

                        $('#quanlytourDetailContent').html(response);
                        $('#quanlytourDetailModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        alert('Có lỗi xảy ra khi tải chi tiết đơn đặt tour!');
                    }
                });
            });
        });
    </script>
@endsection
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
                    url: "{{ route('payment_tour.store') }}",
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
    <script>
        function confirmSubmit(selectElement) {

            console.log("Hàm confirmSubmit đã được gọi!"); // Dòng này kiểm tra sự kiện onchange

            var form = selectElement.form;
            var selectedOption = selectElement.options[selectElement.selectedIndex].text;
            var defaultValue = selectElement.getAttribute('data-default-value');
            if (confirm('Bạn có chắc chắn thay đổi trạng thái đơn hàng"' + selectedOption + '"không?')) {
                form.submit();
            } else {
                selectElement.value = defaultValue;
            }
        }
    </script>
@endsection
