@extends('admin.layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.css') }}" />
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Bình luận</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                                <li class="breadcrumb-item active">Bình luận</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col-sm">
                            <div class="d-flex justify-content-end gap-2">
                                <select id="status" name="status" class="form-select" aria-label="Lọc theo trạng thái"
                                    style="width: 200px;">
                                    <option value="">Lọc theo trạng thái</option>
                                    <option value="1">Hiện</option>
                                    <option value="0">Ẩn</option>
                                </select>

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
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead class="text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ và Tên</th>
                                        <th>Tên tour</th>
                                        <th>Nội dung</th>
                                        <th>Trả lời từ</th>
                                        <th>Thời gian</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Hành động </th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all" id="comment-body">
                                    @if ($listComments->isEmpty())
                                        <tr>
                                            <td colspan="11" class="text-center text-muted">
                                                Trống.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($listComments as $index => $item)
                                            <tr class="comment-item" data-id="{{ $item->id }}">
                                                <td><a href="" class="text-reset">{{ $loop->index + 1 }}</a>
                                                </td>
                                                <td>
                                                    {{ $item->user->name }}
                                                </td>
                                                <td>{{ $item->tour->name }}</td>
                                                <td>{{ $item->content }}</td>
                                                <td>{{ $item->parent ? $item->parent->user->name : 'Bình Luận Chính' }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}
                                                </td>
                                                <td>
                                                    <button type="button" style="width: 100px;"
                                                        class="btn btn-toggle-status {{ $item->status == 1 ? 'btn-success' : 'btn-danger' }}"
                                                        data-id="{{ $item->id }}"
                                                        onclick="toggleStatus({{ $item->id }})">
                                                        {{ $item->status == 1 ? 'Hiện' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">

                                                        <div class="remove">
                                                            <div class="remove">
                                                                <div class="remove">
                                                                    <a href="javascript:void(0);"
                                                                        data-id="{{ $item->id }}"
                                                                        class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"
                                                                        onclick="confirmDelete({{ $item->id }})">
                                                                        <i class="ph-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                        {{-- <div class="row align-items-center mt-4 pt-3" id="pagination-element"
                                style="width: 100%; overflow: hidden;">
                                <div class="col-sm">
                                    <div class="text-muted text-center text-sm-start">
                                        Hiển thị <span class="fw-semibold">{{ $listComments->count() }}</span>
                                        trên <span class="fw-semibold">{{ $listComments->total() }}</span>
                                        mục
                                    </div>
                                </div>

                                <div class="col-sm-auto mt-3 mt-sm-0">
                                    <div class="pagination-wrap hstack justify-content-center gap-2">

                                        @if ($listComments->onFirstPage())
                                            <a class="page-item pagination-prev disabled" href="#">
                                                Trước
                                            </a>
                                        @else
                                            <a class="page-item pagination-prev"
                                                href="{{ $listComments->previousPageUrl() }}">
                                                Trước
                                            </a>
                                        @endif

                                        <ul class="pagination listjs-pagination mb-0">
                                            @foreach ($listComments->getUrlRange(1, $listComments->lastPage()) as $page => $url)
                                                <li class="{{ $listComments->currentPage() == $page ? 'active' : '' }}">
                                                    <a class="page" href="{{ $url }}"
                                                        data-i="{{ $page }}"
                                                        data-page="{{ $page }}">{{ $page }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        @if ($listComments->hasMorePages())
                                            <a class="page-item pagination-next" href="{{ $listComments->nextPageUrl() }}">
                                                Tiếp
                                            </a>
                                        @else
                                            <a class="page-item pagination-next disabled" href="#">
                                                Tiếp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>


@endsection


@section('script')
    <!-- jQuery phải tải đầu tiên -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI (nếu bạn sử dụng các thành phần của jQuery UI) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Bootstrap 5 (nên tải sau jQuery và jQuery UI) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables (tải sau Bootstrap) -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script> --}}

    <!-- SweetAlert2 (tải cuối cùng) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


        $('#status').on('change', function() {
            var status = $(this).val();

            $.ajax({
                url: '{{ route('comment.index') }}',
                method: 'GET',
                data: {
                    status: status
                },
                success: function(response) {
                    console.log(response);
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
                            if (item && item.id) {
                                var created_at = moment(item.created_at).format(
                                    'DD/MM/YYYY HH:mm:ss');
                                rows += `
                            <tr class="comment-item" data-id="${item.id}">
                                <td><a href="" class="text-reset">${item.id}</a></td>
                                <td>${item.user_name}</td>
                                <td>${item.tour_name}</td>
                                <td>${item.content}</td>
                                <td>${item.parent && item.parent.user ? item.parent.user.name : 'Bình Luận Chính'}</td>
                                <td>${created_at}</td>
                                <td>
                                    <button type="button" style="width: 100px;"
                                        class="btn btn-toggle-status ${item.status == 1 ? 'btn-success' : 'btn-danger'}"
                                        onclick="toggleStatus(${item.id})">
                                        ${item.status == 1 ? 'Hiện' : 'Ẩn'}
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <div class="remove">
                                            <a href="javascript:void(0);" data-id="${item.id}"
                                                class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"
                                                onclick="confirmDelete(${item.id})">
                                                <i class="ph-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                            }
                        });
                    }

                    $('#comment-body').html(rows);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Lỗi chi tiết:", jqXHR.responseText);
                    console.error("Text Status:", textStatus);
                    console.error("Error Thrown:", errorThrown);
                    alert('Có lỗi xảy ra! Vui lòng kiểm tra console để biết thêm chi tiết.');
                }
            });
        });
    </script>

    <script>
        function toggleStatus(commentId) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn thay đổi trạng thái của bình luận này?',
                // text: 'Trạng thái sẽ được cập nhật!',
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
                        url: `/admin/comment/status/${commentId}`,
                        method: 'POST',
                        data: {
                            _token: csrfToken // Chỉ cần truyền CSRF token trong data
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // CSRF token cho header
                        },
                        success: function(response) {
                            if (response.success) {
                                const button = $(`button[data-id="${commentId}"]`);
                                if (response.status == 1) {
                                    button.removeClass('btn-danger').addClass('btn-success');
                                    button.text('Hiện');
                                } else {
                                    button.removeClass('btn-success').addClass('btn-danger');
                                    button.text('Ẩn');
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
                                    text: 'Không tìm thấy bình luận!',
                                    showConfirmButton: true,
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Đã xảy ra lỗi khi cập nhật trạng thái: ' +
                                    error,
                                showConfirmButton: true,
                            });
                            console.error(xhr.responseText || error); // In ra lỗi để debug
                        }
                    });
                }
            });
        }

        function confirmDelete(commentId) {
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
                        url: '/admin/comment/delete/' + commentId,
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
                                    // Thử tìm và xóa trực tiếp phần tử chứa bình luận
                                    $('[data-id="' + commentId + '"]').closest('.comment-item')
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
                                text: 'Không thể xóa bình luận. Vui lòng thử lại.',
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
