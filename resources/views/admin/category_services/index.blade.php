@extends('admin.layouts.app')
@section('style')
    <style>
        .status-service {
            width: 100%;
            padding: 10px;

            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: #333;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        .status-service:hover {
            border-color: #025fc9;
            background-color: #e9f7ff;
        }

        .status-service:focus {
            border-color: #007bff;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .status-service option {
            padding: 10px;
            font-size: 16px;
            background-color: #fff;
            color: #333;
        }

        .status-service option:checked {
            background-color: #007bff;
            color: white;
        }



        .pagination-container {
            /* display: flex;    */
            justify-content: end;

        }

        .pagination {
            display: flex;
            gap: 5px;
        }

        .page-item {
            margin: 0 0px;
        }

        .page-item .page-link {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            color: #007bff;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            color: #ccc;
            background-color: #f8f9fa;
            border-color: #ddd;
        }

        .page-link:hover {
            background-color: #0056b3;
            color: white;
            border-color: #0056b3;

        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh Mục Dịch Vụ</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                                <li class="breadcrumb-item active">Danh Mục Dịch Vụ</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <a href="{{ route('category_service.create') }}" class="btn btn-secondary"><i
                                    class="bi bi-plus-circle align-baseline me-1"></i> Thêm mới danh mục dịch vụ</a>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-end gap-2">
                                <select id="status" name="status" class="form-select" aria-label="Lọc theo trạng thái"
                                    style="width: 200px;">
                                    <option value="">Lọc Trạng thái</option>
                                    <option value="1">Đang hoạt động</option>
                                    <option value="0">Không hoạt động</option>
                                </select>
                                <form action="" method="GET">
                                    <div class="search-box">
                                        <input type="text" id="searchInput" class="form-control"
                                            placeholder="Tìm kiếm..." />
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive mt-4 mt-xl-0">

                                        <table class="table table-hover table-striped align-middle table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tên dịch vụ</th>
                                                    <th scope="col">Trạng thái</th>
                                                    <th scope="col">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody id="service-body">
                                                @if ($category_services->isEmpty())
                                                    <tr>
                                                        <td colspan="11" class="text-center text-muted">
                                                            Trống.
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($category_services as $loop => $item)
                                                        <tr class="services-item" data-id="{{ $item->id }}">
                                                            <td class="fw-medium">{{ $loop->index + 1 }}</td>
                                                            <td>{{ $item->category_name }}</td>
                                                            <td>
                                                                <button type="button" style="width: 140px;"
                                                                    class="btn btn-toggle-status {{ $item->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                                    data-id="{{ $item->id }}"
                                                                    onclick="toggleStatus({{ $item->id }})">
                                                                    {{ $item->status == 1 ? 'Đang hoạt động' : 'Không hoạt động' }}
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <ul class="d-flex gap-2 list-unstyled mb-0">
                                                                    <li>
                                                                        <a href="{{ route('category_service.edit', $item->id) }}"
                                                                            class="btn btn-subtle-success btn-icon btn-sm">
                                                                            <i class="ri-edit-2-line"></i></a>
                                                                    </li>
                                                                    {{-- <li>
                                                                        <a class="btn btn-subtle-danger btn-icon btn-sm view-tour"
                                                                            data-id="{{ $item->id }}">
                                                                            <i class="ph-trash"></i>
                                                                        </a>
                                                                    </li> --}}
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>


                                    </div>
                                    <div class="pagination-container mt-4">
                                        {{-- {{ $services->links('pagination::bootstrap-5') }} --}}
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="card-body bg-light border-bottom border-top bg-opacity-25">
                            <h5 class="fs-xs text-muted mb-0"></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleStatus(userId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn thay đổi trạng thái?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, thay đổi',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/category_service/status/${userId}`,
                        method: 'POST',
                        data: {
                            _token: csrfToken
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                const button = $(`button[data-id="${userId}"]`);
                                if (response.status == 1) {
                                    button.removeClass('btn-danger').addClass('btn-success');
                                    button.text('Đang hoạt động');
                                } else {
                                    button.removeClass('btn-success').addClass('btn-danger');
                                    button.text('Không hoạt động');
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: 'Trạng thái cập nhật thành công!',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    timerProgressBar: true,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: response.message || 'Đã xảy ra lỗi không xác định.',
                                    showConfirmButton: true,
                                });
                            }


                        },
                        error: function(xhr) {
                            let errorMessage = 'Đã xảy ra lỗi khi cập nhật trạng thái.';
                            if (xhr.status === 403 && xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: errorMessage,
                                showConfirmButton: true,
                            });

                            console.error(xhr.responseJSON || xhr.responseText);
                        }
                    });
                }
            });
        }


        // function confirmDelete(servicesId) {
        //     Swal.fire({
        //         title: 'Bạn có chắc muốn xóa bình luận này?',
        //         text: "Hành động này không thể hoàn tác!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#d33',
        //         cancelButtonColor: '#3085d6',
        //         confirmButtonText: 'Xóa',
        //         cancelButtonText: 'Hủy'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 url: '/admin/services/delete/' + servicesId,
        //                 method: 'DELETE',
        //                 data: {
        //                     "_token": "{{ csrf_token() }}",
        //                 },
        //                 success: function(response) {
        //                     if (response.success) {
        //                         Swal.fire({
        //                             icon: 'success',
        //                             title: 'Xóa bình luận thành công!',
        //                             showConfirmButton: false,
        //                             timer: 1500
        //                         }).then(() => {

        //                             $('[data-id="' + servicesId + '"]').closest(
        //                                     '.services-item')
        //                                 .remove();
        //                         });
        //                     } else {
        //                         Swal.fire({
        //                             icon: 'error',
        //                             title: 'Có lỗi xảy ra',
        //                             text: 'Vui lòng thử lại sau.',
        //                         });
        //                     }
        //                 },
        //                 error: function(xhr, status, error) {
        //                     console.log(xhr, status, error);
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Có lỗi xảy ra',
        //                         text: 'Không thể xóa liên hệ tư vấn. Vui lòng thử lại.',
        //                     });
        //                 }
        //             });
        //         }
        //     });
        // }




        $(document).ready(function() {
            var isSearchingOrFiltering = $('#searchInput').length > 0 || $('#filterSelect').length > 0;

            $('.status').each(function() {
                $(this).data('previous-value', $(this).val());
            });

            if (!isSearchingOrFiltering) {
                $('.status').change(function() {
                    var serviceId = $(this).data('service-id');
                    var newStatus = $(this).val();
                    var selectElement = $(this);

                    var oldValue = selectElement.data('previous-value');

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn thay đổi trạng thái?',
                        text: "Trạng thái sẽ được cập nhật!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Có, thay đổi',
                        cancelButtonText: 'Hủy',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/category_service/status/' + serviceId,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    status: newStatus
                                },
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



                                        selectElement.data('previous-value', newStatus);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: response.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                        selectElement.val(oldValue);
                                    }
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Đã có lỗi xảy ra. Vui lòng thử lại!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    selectElement.val(oldValue);
                                }
                            });
                        } else {
                            selectElement.val(oldValue);
                        }
                    });
                });
            } else {
                $(document).on('change', '.status', function() {
                    var serviceId = $(this).data('service-id');
                    var newStatus = $(this).val();
                    var selectElement = $(this);
                    var oldValue = selectElement.data('previous-value');

                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn thay đổi trạng thái?',
                        text: "Trạng thái sẽ được cập nhật!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Có, thay đổi',
                        cancelButtonText: 'Hủy',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/category_service/status/' + serviceId,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    status: newStatus
                                },
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

                                        if (newStatus == 'Đã hoàn tất' || newStatus ==
                                            'Hủy bỏ') {
                                            selectElement.prop('disabled', true);
                                        } else {
                                            selectElement.prop('disabled', false);
                                        }

                                        selectElement.data('previous-value', newStatus);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: response.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                        selectElement.val(oldValue);
                                    }
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Đã có lỗi xảy ra. Vui lòng thử lại!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    selectElement.val(oldValue);
                                }
                            });
                        } else {
                            selectElement.val(oldValue);
                        }
                    });
                });
            }
        });


        $('#status').on('change', function() {
            var status = $(this).val();

            $.ajax({
                url: '{{ route('category_service.index') }}',
                method: 'GET',
                data: {
                    status: status
                },
                success: function(response) {
                    // console.log(response); 

                    var rows = '';

                    if (response.data && response.data.length === 0) {
                        rows += `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Trống.
                    </td>
                </tr>
            `;
                    } else {
                        $.each(response.data, function(index, item) {
                            if (item && item.id) {

                                rows += `
                        <tr class="services-item" data-id="${item.id}">
                            <td class="fw-medium">${index + 1}</td>
                            <td>${item.category_name}</td>
                        
                            <td>
                                <button type="button" style="width: 140px;"
                                    class="btn btn-toggle-status ${item.status == 1 ? 'btn-success' : 'btn-danger'}"
                                    data-id="${item.id}"
                                    onclick="toggleStatus(${item.id})">
                                    ${item.status == 1 ? 'Đang hoạt động' : 'Không hoạt động'}
                                </button>
                            </td>
                            <td>
                                <ul class="d-flex gap-2 list-unstyled mb-0">
                                    <li>
                                        <a href="/admin/service/edit/${item.id}" class="btn btn-subtle-success btn-icon btn-sm">
                                            <i class="ri-edit-2-line"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    `;
                            }
                        });
                    }

                    $('#service-body').html(rows); // Cập nhật lại nội dung của tbody
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Lỗi chi tiết:", jqXHR.responseText);
                    console.error("Text Status:", textStatus);
                    console.error("Error Thrown:", errorThrown);
                    alert('Có lỗi xảy ra! Vui lòng kiểm tra console để biết thêm chi tiết.');
                }
            });
        });

        $('#searchInput').on('input', function() {
            var searchQuery = $(this).val();

            $.ajax({
                url: '{{ route('category_service.index') }}', // URL gửi request tìm kiếm
                method: 'GET',
                data: {
                    search: searchQuery,
                    _token: '{{ csrf_token() }}' // CSRF token để bảo mật request
                },
                success: function(response) {
                    console.log(response); // Kiểm tra dữ liệu trả về từ search

                    var rows = '';

                    if (response.data && response.data.length === 0) {
                        rows += `
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Trống.
                    </td>
                </tr>
            `;
                    } else {
                        $.each(response.data, function(index, item) {
                            if (item && item.id) {

                                rows += `
                        <tr class="services-item" data-id="${item.id}">
                            <td class="fw-medium">${index + 1}</td>
                            <td>${item.category_name}</td>
                           
                            <td>
                                <button type="button" style="width: 140px;"
                                    class="btn btn-toggle-status ${item.status == 1 ? 'btn-success' : 'btn-danger'}"
                                    data-id="${item.id}"
                                    onclick="toggleStatus(${item.id})">
                                    ${item.status == 1 ? 'Đang hoạt động' : 'Không hoạt động'}
                                </button>
                            </td>
                            <td>
                                <ul class="d-flex gap-2 list-unstyled mb-0">
                                    <li>
                                        <a href="/admin/service/edit/${item.id}" class="btn btn-subtle-success btn-icon btn-sm">
                                            <i class="ri-edit-2-line"></i>
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    `;
                            }
                        });
                    }

                    $('#service-body').html(rows); // Cập nhật lại nội dung của tbody
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Lỗi chi tiết:", jqXHR.responseText);
                    console.log("Text Status:", textStatus);
                    console.log("Error Thrown:", errorThrown);
                    alert('Có lỗi xảy ra!');
                }
            });
        });
    </script>
@endsection
