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
                        <h4 class="mb-sm-0">Quản Lý Đánh Giá</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Danh sách đánh giá</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>

                            </div>
                        </div>

                        <div class="col-sm">
                            <form action="" method="GET">
                                <div class="d-flex justify-content-sm-end">

                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control search" placeholder="Search..."
                                            id="searchInput" value="{{ request()->get('search') }}" name="search">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                    <button class="btn btn-dark" style="margin-left:10px ">Tìm kiếm</button>

                                </div>
                            </form>
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
                                            <th>Đánh giá</th>
                                            <th>Ngày đánh giá</th>
                                            <th scope="col">Hành động </th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @if ($listReview->isEmpty())
                                            <tr>
                                                <td colspan="11" class="text-center text-muted">
                                                    Trống.
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($listReview as $index => $item)
                                                <tr class="comment-item" data-id="{{ $item->id }}">
                                                    <td><a href="" class="text-reset">{{ $loop->index + 1 }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $item->user->name }}
                                                    </td>
                                                    <td>{{ $item->tour->name }}</td>
                                                    <td>{{ $item->rating }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                 
                                                    <td>
                                                        <ul class="d-flex gap-2 list-unstyled mb-0">
                                                            <li>
                                                                <a href="#deleteRecordModal{{ $item->id }}"
                                                                    data-bs-toggle="modal"
                                                                    class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"><i
                                                                        class="ph-trash"></i></a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    </td>
                                                </tr>
                                                <div id="deleteRecordModal{{ $item->id }}" class="modal fade zoomIn"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close"
                                                                    id="deleteRecord-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body p-md-5">
                                                                <div class="text-center">
                                                                    <div class="text-danger">
                                                                        <i class="bi bi-trash display-5"></i>
                                                                    </div>
                                                                    <div class="mt-4">
                                                                        <h4 class="mb-2">Xóa mục này?</h4>
                                                                        <p class="text-muted mx-3 mb-0">Bạn có chắc chắn
                                                                            muốn
                                                                            xóa không?</p>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="d-flex gap-2 justify-content-center mt-4 pt-2 mb-2">
                                                                    <form action="{{ route('review.destroy', $item->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button"
                                                                            class="btn w-sm btn-light btn-hover"
                                                                            data-bs-dismiss="modal">Đóng</button>
                                                                        <button type="submit"
                                                                            class="btn w-sm btn-danger btn-hover"
                                                                            id="delete-record">Vâng, Tôi chắc chắn muốn
                                                                            xóa!</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="noresult" style="display: none">
                                    <div class="text-center py-4">
                                        <i class="ph-magnifying-glass fs-1 text-primary"></i>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Courses but did not find
                                            any matching results.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mt-4 pt-3" id="pagination-element"
                                style="width: 100%; overflow: hidden;">
                                <div class="col-sm">
                                    <div class="text-muted text-center text-sm-start">
                                        Hiển thị <span class="fw-semibold">{{ $listReview->count() }}</span>
                                        trên <span class="fw-semibold">{{ $listReview->total() }}</span>
                                        mục
                                    </div>
                                </div>

                                <div class="col-sm-auto mt-3 mt-sm-0">
                                    <div class="pagination-wrap hstack justify-content-center gap-2">

                                        @if ($listReview->onFirstPage())
                                            <a class="page-item pagination-prev disabled" href="#">
                                                Trước
                                            </a>
                                        @else
                                            <a class="page-item pagination-prev"
                                                href="{{ $listReview->previousPageUrl() }}">
                                                Trước
                                            </a>
                                        @endif

                                        <ul class="pagination listjs-pagination mb-0">
                                            @foreach ($listReview->getUrlRange(1, $listReview->lastPage()) as $page => $url)
                                                <li class="{{ $listReview->currentPage() == $page ? 'active' : '' }}">
                                                    <a class="page" href="{{ $url }}"
                                                        data-i="{{ $page }}"
                                                        data-page="{{ $page }}">{{ $page }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        @if ($listReview->hasMorePages())
                                            <a class="page-item pagination-next" href="{{ $listReview->nextPageUrl() }}">
                                                Tiếp
                                            </a>
                                        @else
                                            <a class="page-item pagination-next disabled" href="#">
                                                Tiếp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection


@section('script')
    <script>
        $(document).ready(function() {
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
                    }
                }
            });
        });
    </script>
@endsection
