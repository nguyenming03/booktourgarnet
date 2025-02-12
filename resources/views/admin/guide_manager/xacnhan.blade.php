@extends('admin.layouts.app')
@section('title')
    <title>Lịch Trình | Quản Trị</title>
@endsection
@section('style')
    {{-- <!--datatable css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> --}}
    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/dataTables.css') }}" /> --}}
    <style>
        /* Chỉ áp dụng cho phần accordion */
        .page-content .accordion {
            background-color: #f9f9f9;
            padding: 40px 0;
        }

        .page-content .accordion .title-info {
            font-weight: bold;
            font-size: 2.4rem;
            text-transform: uppercase;
            /* color: #4CAF50; */
            margin-bottom: 20px;
        }

        /* Success and error messages */
        .page-content .accordion .alert {
            margin-top: 20px;
            border-radius: 8px;
            padding: 15px;
        }

        .page-content .accordion .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .page-content .accordion .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Accordion item styling */
        .page-content .accordion .accordion-item {
            background-color: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 15px;
        }

        .page-content .accordion .accordion-item-title {
            font-weight: bold;
            font-size: 1.1rem;
            display: block;
            color: #333;
            cursor: pointer;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .page-content .accordion .accordion-item-title:hover {
            background-color: #e2e6ea;
        }

        .page-content .accordion .accordion-item-desc {
            font-size: 1rem;
            margin-top: 10px;
            color: #555;
            padding-left: 20px;
        }

        /* Button styling */
        .page-content .accordion .btn {
            font-weight: bold;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 5px;
        }

        .page-content .accordion .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .page-content .accordion .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .page-content .accordion .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .page-content .accordion .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .page-content .accordion .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .page-content .accordion .btn:hover {
            opacity: 0.9;
        }

        /* Textarea for issue form */
        .page-content .accordion .issue-form {
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            display: none;
        }

        .page-content .accordion .issue-reason {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .page-content .accordion .issue-reason:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .page-content .accordion .accordion-item-title {
                font-size: 1rem;
                padding: 8px;
            }

            .page-content .accordion .accordion-item-desc {
                font-size: 0.9rem;
            }

            .page-content .accordion {
                padding: 20px 0;
            }

            .page-content .accordion .container-fluid {
                padding: 20px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="accordion">
                        <h3 class="title-info text-center"
                            style="font-weight: bold; font-size: 2.4rem; text-transform: uppercase;">
                            LỊCH TRÌNH
                        </h3>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <spsan>{{ session('error') }}</spsan>
                        @endif
                        <div class="container">
                            <div class="col-lg-12">
                                <div class="card" id="coursesList">
                                    @foreach ($tourLocations as $index => $location)
                                        <div class="accordion-item">
                                            {{-- <input type="checkbox" id="accordion{{ $index + 1 }}"> --}}
                                            <label for="accordion{{ $index + 1 }}" class="accordion-item-title">
                                                <span class="icon"></span>
                                                <b>Ngày {{ $index + 1 }}:
                                                    <span>{{ $location->start }} - {{ $location->end }}</span>
                                                </b>
                                            </label>
                                            <div class="accordion-item-desc">{{ $location->description }}</div>
                                            <!-- Hiển thị nút xác nhận nếu status = 0 -->
                                            @if ($location->status == 0)
                                                <div class="text-right mt-2">
                                                    <button class="btn btn-success confirm-btn"
                                                        data-id="{{ $location->id }}" style="font-weight: bold;">
                                                        Xác nhận
                                                    </button>
                                                    <button class="btn btn-danger issue-btn" data-id="{{ $location->id }}"
                                                        style="font-weight: bold;">
                                                        Tour gặp sự cố
                                                    </button>
                                                </div>

                                                <!-- Form nhập lý do gặp sự cố -->
                                                <div class="issue-form mt-2" id="issueForm-{{ $location->id }}"
                                                    style="display: none;">
                                                    <textarea class="form-control issue-reason" rows="3" placeholder="Nhập lý do..." data-id="{{ $location->id }}"></textarea>
                                                    <button class="btn btn-warning submit-issue-btn mt-2"
                                                        data-id="{{ $location->id }}" style="font-weight: bold;">
                                                        Gửi
                                                    </button>
                                                </div>
                                            @endif

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Nút hoàn thành tour -->
                        {{-- <div class="text-center mt-4">
              <button id="complete-tour-btn" class="btn btn-primary"
                      style="font-weight: bold; display: {{ $allConfirmed ? 'block' : 'none' }};">
                  Hoàn thành tour
              </button>
          </div> --}}
                        <div class="text-center">
                            @foreach ($guideTours->tours as $item)
                                @if ($item->pay && $item->pay->status_id != 6)
                                    <form action="{{ route('guide-manager.updateStatusPayment', $item->pay_id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH') <!-- Đây là cách gửi phương thức PATCH -->
                                        <button type="submit" class="btn btn-primary">Xác nhận hoàn thành tour</button>
                                    </form>
                                @endif
                                @if ($item->pay && $item->pay->status_id == 6)
                                    <button type="submit" class="btn btn-info">Đã hoàn thành tour</button>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const issueButtons = document.querySelectorAll(".issue-btn");
            const submitIssueButtons = document.querySelectorAll(".submit-issue-btn");
            // Hiển thị form nhập lý do khi bấm nút "Tour gặp sự cố"
            issueButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const locationId = this.getAttribute("data-id");
                    const issueForm = document.getElementById(`issueForm-${locationId}`);
                    if (issueForm) {
                        issueForm.style.display = "block";
                    }
                });
            });
            // Gửi lý do gặp sự cố
            submitIssueButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const locationId = this.getAttribute("data-id");
                    const reasonTextarea = document.querySelector(
                        `.issue-reason[data-id="${locationId}"]`);
                    const reason = reasonTextarea.value.trim();
                    if (!reason) {
                        alert("Vui lòng nhập lý do.");
                        return;
                    }
                    fetch(`{{ route('guide-manager.reportIssue', '') }}/${locationId}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                reason
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Tour đã được cập nhật trạng thái gặp sự cố.");
                                location.reload();
                            } else {
                                alert(data.message || "Đã xảy ra lỗi, vui lòng thử lại.");
                            }
                        })
                        .catch(error => {
                            alert("Có lỗi xảy ra, vui lòng thử lại.");
                            console.error("Error:", error);
                        });
                });
            });
        });
    </script>
    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const confirmButtons = document.querySelectorAll(".confirm-btn");
            const completeTourBtn = document.getElementById("complete-tour-btn");
            // Xử lý xác nhận từng lịch trình
            confirmButtons.forEach(button => {
                button.addEventListener("click", function() {
                    const locationId = this.getAttribute("data-id");
                    if (confirm("Bạn có chắc chắn xác nhận lịch trình này không?")) {
                        fetch(`{{ route('guide-manager.updateLocationStatus', '') }}/${locationId}`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    locationId,
                                    status: 1
                                }) // Cập nhật status = 1
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Lịch trình đã được xác nhận thành công!");
                                    location.reload(); // Tải lại trang để cập nhật trạng thái
                                } else {
                                    alert(data.message || "Đã xảy ra lỗi, vui lòng thử lại.");
                                }
                            })
                            .catch(error => {
                                alert("Có lỗi xảy ra, vui lòng thử lại.");
                                console.error("Error:", error);
                            });
                    }
                });
            });
            // Xử lý hoàn thành tour
            if (completeTourBtn) {
                completeTourBtn.addEventListener("click", function() {
                    if (confirm("Bạn có chắc chắn muốn hoàn thành tour này không?")) {
                        fetch(`{{ route('guide-manager.updateStatusPayment', $payment->id) }}`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Tour đã được hoàn thành thành công!");
                                    location.reload();
                                } else {
                                    alert(data.message || "Đã xảy ra lỗi, vui lòng thử lại.");
                                }
                            })
                            .catch(error => {
                                alert("Có lỗi xảy ra, vui lòng thử lại123.");
                                console.error("Error:", error);
                            });
                    }
                });
            }
        });
    </script>
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
    </script>
@endsection
