@extends('admin.layouts.app')

@section('style')
    <style>
        .table-layout-fixed {
            width: 100%;
            table-layout: fixed;
        }

        .table-custom th {
            width: 30%%;

            text-align: left;

            vertical-align: top;

            font-weight: bold;
        }

        .table-custom td {
            width: 70%;
            text-align: right;
        }



        .accordion {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .accordion__item {
            border: 1px solid #e5f3fa;
            border-radius: 10px;
            overflow: hidden;
        }

        .accordion__header {
            padding: 20px 25px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
        }

        .accordion__header::after {
            content: '';
            background: url(https://www.svgrepo.com/show/357035/angle-down.svg) no-repeat center;
            width: 20px;
            height: 20px;
            transition: .4s;
            display: inline-block;
            position: absolute;
            right: 20px;
            top: 20px;
            z-index: 1;
        }

        .accordion__header.active {
            background: #e5f3fa;
        }

        .accordion__header.active::after {
            transform: rotateX(180deg);
        }

        .accordion__item .accordion__content {
            padding: 0 25px;
            max-height: 0;
            transition: .5s;
            overflow: hidden;
        }

        .card-body img {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Chi Tiết Tour: <span style="color: rgb(15, 136, 192)">{{ $tour->name }}</span>
                        </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Trang Chủ</a>
                                </li>
                                <li class="breadcrumb-item active">Chi Tiết Tour</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card">
                <div class="row g-0">
                    <div class="col-xl-7 col-lg-8">
                        <div class="card-body border-end h-100">
                            <div class="row mb-4 pb-2 g-3">
                                <div class="col-auto">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-success-subtle rounded">
                                            <img src="{{ Storage::url($tour->image) }}" alt="" class="avatar-xs">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md order-3 order-md-2">
                                    <div>
                                        <h5>{{ $tour->name }}</h5>
                                        <div class="hstack gap-2 gap-md-3 flex-wrap">

                                            <div class="text-muted">Ngày bắt đầu : <span class="fw-medium "
                                                    id="create-date">{{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}
                                                </span></div>
                                            <div class="vr"></div>
                                            <div class="text-muted">Ngày kết thúc : <span class="fw-medium"
                                                    id="due-date">{{ \Carbon\Carbon::parse($tour->end_date)->format('d/m/Y') }}
                                                </span></div>
                                            <div class="vr"></div>
                                            {{-- <div class="badge rounded-pill bg-info fs-12" id="ticket-status">New
                                             </div>
                                            <div class="badge rounded-pill bg-danger fs-12" id="ticket-priority">High</div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="fw-semibold text-uppercase mb-2">Mô tả:</h6>
                            <p class="text-muted mb-4">{!! $tour->content ?? '' !!}</p>
                            <h6 class="fw-semibold text-uppercase mb-3">Dịch vụ:
                            </h6>
                            <table class="table table-bordered align-middle table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên dịch vụ</th>
                                        <th>Danh mục</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tour->services->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center"
                                                style="background-color: rgb(229, 238, 238)"><b>KHÔNG
                                                    CÓ DỊCH VỤ</b></td>
                                        </tr>
                                    @else
                                        @foreach ($tour->services as $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td>
                                                    @if ($service->categoryService)
                                                        {{ $service->categoryService->category_name }}
                                                    @else
                                                        Không có danh mục
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>
                            <br>
                            <h6 class="fw-semibold text-uppercase mb-3">Lịch trình: </h6>


                            <div class="accordion">
                                @foreach ($tourLocations as $index => $location)
                                    <div class="accordion__item">
                                        <div class="accordion__header" data-toggle="#faq{{ $index + 1 }}"> Ngày
                                            {{ $index + 1 }}: {{ $location->start }} - {{ $location->end }}</div>
                                        <div class="accordion__content" id="faq{{ $index + 1 }}">
                                            <p style="margin-top: 10px;"> {{ $location->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                    </div><!--end col-->
                    <div class="col-xl-5 col-lg-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Chi tiết vé</h6><br>
                            <h4 style="width: 100%; color: rgb(15, 136, 192)">{{ $tour->journeys }}</h4>
                        </div>
                        <div class="card-body mt-2">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless align-middle mb-0 table-custom">
                                    <tbody>

                                        {{-- <tr>
                                            <th class="text-start">Lịch trình:</th>
                                            <td id="t-client">{{ $tour->schedule }}</td>
                                        </tr> --}}
                                        <tr>
                                            <th>Phương tiện di chuyển:</th>
                                            <td>{{ $tour->move_method }}</td>
                                        </tr>

                                        <tr>
                                            <th class="text-start">Trạng thái:</th>
                                            <td>
                                                @if ($tour->status == 1)
                                                    <span class="text-success fw-bold" id="t-status" data-choices
                                                        data-choices-search-false aria-label="Default select example">Hiển
                                                        Thị</span>
                                                @else
                                                    <span class="text-danger fw-bold" id="t-status" data-choices
                                                        data-choices-search-false
                                                        aria-label="Default select example">Ẩn</span>
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Số lượng khách:</th>
                                            <td>
                                                {{ $tour->number_guests }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Ngày khởi hành:</th>
                                            <td id="c-date">
                                                {{ $tour->start_date ? \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y H:i') : 'Chưa xác định' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Ngày kết thúc</th>
                                            <td id="d-date">
                                                {{ $tour->start_date ? \Carbon\Carbon::parse($tour->end_date)->format('d/m/Y H:i') : 'Chưa xác định' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Giá người lớn</th>
                                            <td>{{ number_format($tour->price_old, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Giá trẻ em</th>
                                            <td>{{ number_format($tour->price_children, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Giảm giá</th>
                                            <td>{{ $tour->sale }}%</td>
                                        </tr>
                                        {{-- <tr>
                                            <th class="text-start">Lượt xem</th>
                                            <td>{{ $tour->view }}</td>
                                        </tr> --}}

                                        <tr>
                                            <th class="text-start">Mô tả:</th>
                                            <td>{!! $tour->description !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Địa điểm:</th>
                                            <td>{{ $tour->location->name }}</td>
                                        </tr>


                                        <tr>
                                            <th class="text-start">Ngày đăng:</th>
                                            <td id="d-date">
                                                {{ $tour->created_at ? \Carbon\Carbon::parse($tour->end_date)->format('d/m/Y H:i') : 'Chưa xác định' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-start">Ngày cập nhật</th>
                                            <td id="d-date">
                                                {{ $tour->updated_at ? \Carbon\Carbon::parse($tour->end_date)->format('d/m/Y H:i') : 'Chưa xác định' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <div class="card-body text-end">
                <a href="{{ route('tour.index') }}" class="btn btn-secondary" style="width: 120px"><i
                        class="ri-arrow-go-back-line align-baseline me-1"></i> Quay lại</a>
            </div>
            <br>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglers = document.querySelectorAll('[data-toggle]');

            togglers.forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    const selector = e.currentTarget.dataset.toggle
                    const block = document.querySelector(`${selector}`);
                    if (e.currentTarget.classList.contains('active')) {
                        block.style.maxHeight = '';
                    } else {
                        block.style.maxHeight = block.scrollHeight + 'px';
                    }

                    e.currentTarget.classList.toggle('active')
                })
            })
        })
    </script>
@endsection
