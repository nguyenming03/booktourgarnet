@extends('admin.layouts.app')
@section('style')
    <style>
        .status-contact {
            width: 100%;
            padding: 10px;

            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            color: #333;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        .status-contact:hover {
            border-color: #025fc9;
            background-color: #e9f7ff;
        }

        .status-contact:focus {
            border-color: #007bff;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .status-contact option {
            padding: 10px;
            font-size: 16px;
            background-color: #fff;
            color: #333;
        }

        .status-contact option:checked {
            background-color: #007bff;
            color: white;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tư vấn liên hệ</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="">Trang chủ</a></li>
                                <li class="breadcrumb-item active">Tư vấn</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col-sm">
                            <div class="d-flex justify-content-end gap-2">
                                <select id="status" name="status" class="form-select" aria-label="Lọc theo trạng thái"
                                    style="width: 200px;">
                                    <option value="">Lọc Trạng thái</option>
                                    <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                                    <option value="Đang tư vấn">Đang tư vấn</option>
                                    <option value="Đã hoàn tất">Đã hoàn tất</option>
                                    <option value="Hủy bỏ">Hủy bỏ</option>
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
                                                    <th scope="col">Họ và Tên</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Chủ đề</th>
                                                    <th scope="col">Nội dung</th>
                                                    <th scope="col">Trạng thái</th>
                                                    <th scope="col">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contact-body">
                                                @if ($contact->isEmpty())
                                                    <tr>
                                                        <td colspan="11" class="text-center text-muted">
                                                            Trống.
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($contact as $loop => $item)
                                                        <tr class="contact-item" data-id="{{ $item->id }}">
                                                            <td class="fw-medium">{{ $loop->index + 1 }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->email }}</td>
                                                            <td>{{ $item->subject }}</td>
                                                            <td>{{ $item->message }}</td>
                                                            <td>
                                                                <select class="form-control status-contact"
                                                                    data-contact-id="{{ $item->id }}"
                                                                    @if ($item->status == 'Đã hoàn tất' || $item->status == 'Hủy bỏ') disabled @endif>
                                                                    <option value="Đang chờ xử lý"
                                                                        {{ $item->status == 'Đang chờ xử lý' ? 'selected' : '' }}>
                                                                        Đang chờ xử lý</option>
                                                                    <option value="Đang tư vấn"
                                                                        {{ $item->status == 'Đang tư vấn' ? 'selected' : '' }}>
                                                                        Đang tư vấn</option>
                                                                    <option value="Đã hoàn tất"
                                                                        {{ $item->status == 'Đã hoàn tất' ? 'selected' : '' }}>
                                                                        Đã hoàn tất</option>
                                                                    <option value="Hủy bỏ"
                                                                        {{ $item->status == 'Hủy bỏ' ? 'selected' : '' }}>
                                                                        Hủy bỏ</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-2">
                                                                    <div class="remove">
                                                                        <a href="javascript:void(0);"
                                                                            data-id="{{ $item->id }}"
                                                                            class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"
                                                                            onclick="confirmDelete({{ $item->id }})">
                                                                            <i class="ph-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
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
        function confirmDelete(contactId) {
            Swal.fire({
                title: 'Bạn có chắc muốn xóa bình luận này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/contact/delete/' + contactId,
                        method: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Xóa bình luận thành công!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {

                                    $('[data-id="' + contactId + '"]').closest(
                                            '.contact-item')
                                        .remove();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Có lỗi xảy ra',
                                    text: 'Vui lòng thử lại sau.',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr, status, error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Có lỗi xảy ra',
                                text: 'Không thể xóa liên hệ tư vấn. Vui lòng thử lại.',
                            });
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            var isSearchingOrFiltering = $('#searchInput').length > 0 || $('#filterSelect').length > 0;
            $('.status-contact').each(function() {
                $(this).data('previous-value', $(this).val());
            });

            if (!isSearchingOrFiltering) {
                $('.status-contact').change(function() {
                    var contactId = $(this).data('contact-id');
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
                                url: '/admin/contact/status/' + contactId,
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
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Đã có lỗi xảy ra. Vui lòng thử lại!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    selectElement.val(oldValue);
                                }
                            });
                        }
                    });
                });
            } else {
                $(document).on('change', '.status-contact', function() {
                    var contactId = $(this).data('contact-id');
                    var newStatus = $(this).val();
                    var selectElement = $(this);

                    var oldValue = selectElement.data('previous-value');

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
                            $.ajax({
                                url: '/admin/contact/status/' + contactId,
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
                url: '{{ route('admin.contact.index') }}',
                method: 'GET',
                data: {
                    status: status
                },
                success: function(response) {
                    var rows = '';

                    if (response.data.length === 0) {
                        rows += `
                   <tr>
                       <td colspan="8" class="text-center text-muted">
                           Trống.
                       </td>
                   </tr>
               `;
                    } else {
                        $.each(response.data, function(index, item) {
                            rows += `
                       <tr class="contact-item" data-id="${item.id}">
                           <td class="fw-medium">${index + 1}</td>
                           <td>${item.name}</td>
                           <td>${item.email}</td>
                           <td>${item.subject}</td>
                           <td>${item.message}</td>
                           <td>
                               <select class="form-control status-contact" data-contact-id="${item.id}" 
                                   ${['Đã hoàn tất', 'Hủy bỏ'].includes(item.status) ? 'disabled' : ''}>
                                   <option value="Đang chờ xử lý" ${item.status === 'Đang chờ xử lý' ? 'selected' : ''}>Đang chờ xử lý</option>
                                   <option value="Đang tư vấn" ${item.status === 'Đang tư vấn' ? 'selected' : ''}>Đang tư vấn</option>
                                   <option value="Đã hoàn tất" ${item.status === 'Đã hoàn tất' ? 'selected' : ''}>Đã hoàn tất</option>
                                   <option value="Hủy bỏ" ${item.status === 'Hủy bỏ' ? 'selected' : ''}>Hủy bỏ</option>
                               </select>
                           </td>
                           <td>
                               <div class="d-flex gap-2">
                                   <div class="remove">
                                       <a href="javascript:void(0);" data-id="${item.id}" class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn" onclick="confirmDelete(${item.id})">
                                           <i class="ph-trash"></i>
                                       </a>
                                   </div>
                               </div>
                           </td>
                       </tr>
                   `;
                        });
                    }

                    $('#contact-body').html(rows);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error:", errorThrown);
                    alert('Có lỗi xảy ra!');
                }
            });
        });


        $('#searchInput').on('input', function() {
            var searchQuery = $(this).val();

            $.ajax({
                url: '{{ route('admin.contact.index') }}',
                method: 'GET',
                data: {
                    search: searchQuery,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var rows = '';

                    if (response.data.length === 0) {
                        rows += `
                   <tr>
                       <td colspan="8" class="text-center text-muted">
                           Trống.
                       </td>
                   </tr>
               `;
                    } else {
                        $.each(response.data, function(index, item) {
                            rows += `
                       <tr class="contact-item" data-id="${item.id}">
                           <td class="fw-medium">${index + 1}</td>
                           <td>${item.name}</td>
                           <td>${item.email}</td>
                           <td>${item.subject}</td>
                           <td>${item.message}</td>
                           <td>
                               <select class="form-control status-contact" data-contact-id="${item.id}" 
                                   ${['Đã hoàn tất', 'Hủy bỏ'].includes(item.status) ? 'disabled' : ''}>
                                   <option value="Đang chờ xử lý" ${item.status === 'Đang chờ xử lý' ? 'selected' : ''}>Đang chờ xử lý</option>
                                   <option value="Đang tư vấn" ${item.status === 'Đang tư vấn' ? 'selected' : ''}>Đang tư vấn</option>
                                   <option value="Đã hoàn tất" ${item.status === 'Đã hoàn tất' ? 'selected' : ''}>Đã hoàn tất</option>
                                   <option value="Hủy bỏ" ${item.status === 'Hủy bỏ' ? 'selected' : ''}>Hủy bỏ</option>
                               </select>   
                           </td>
                           <td>
                               <div class="d-flex gap-2">
                                   <div class="remove">
                                       <a href="javascript:void(0);" data-id="${item.id}" class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn" onclick="confirmDelete(${item.id})">
                                           <i class="ph-trash"></i>
                                       </a>
                                   </div>
                               </div>
                           </td>
                       </tr>
                   `;
                        });
                    }

                    $('#contact-body').html(rows);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Có lỗi xảy ra!');
                }
            });
        });
    </script>
@endsection
