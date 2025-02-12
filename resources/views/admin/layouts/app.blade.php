<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable"
    data-theme="default" data-topbar="light" data-bs-theme="light">

<head>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <meta charset="utf-8">
    @if (!empty($title))
        <title>{{ !empty($title) ? $title : '' }} | Quản Trị</title>
    @endif

    @yield('title')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link id="fontsLink"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <link href="{{ asset('admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('admin/assets/js/layout.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>


    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    @yield('style')

</head>

<body>


    <div id="layout-wrapper">

        @include('admin.layouts.header')
        @include('admin.layouts.navbar')

        <div class="main-content">

            @yield('content')

            @include('admin.layouts.footer')
        </div>


    </div>



    <!--start back-to-top-->
    <button class="btn btn-dark btn-icon" id="back-to-top">
        <i class="bi bi-caret-up fs-3xl"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>



    <!-- JAVASCRIPT -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    </script>
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/assets/js/plugins.js') }}"></script> --}}

    <!-- apexcharts -->
    <script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('admin/assets/libs/list.js/list.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>

    {{-- Sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    {{-- thống kê ajax --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> --}}


    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script>
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const timeframe = this.getAttribute('href'); // Lấy khoảng thời gian từ href
                fetch(`/doanh-thu/${timeframe}`)
                    .then(response => response.json())
                    .then(data => {
                        // Cập nhật doanh thu và phần trăm thay đổi trong view
                        document.querySelector('.counter-value').setAttribute('data-target', data.totalMoney);
                        document.querySelector('.counter-value').textContent = new Intl.NumberFormat().format(data.totalMoney) + ' đ';
                        document.querySelector('.text-success').textContent = data.percentage + ' %';
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script> --}}



    {{-- <script>
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $("#datepicker2").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });


        $('#btn-dashboard-filter').click(function() {
            var _token = $('input[name="_token"]').val();
            var from_date = $('#datepicker').val();
            var to_date = $('#datepicker2').val();
            // alert(from_date);
            // alert(to_date);
            if (chart && typeof chart.setData === 'function') {
                chart.setData(data);
                console.log("Dữ liệu đã được tải thành công.");
            } else {
                console.error("Chart chưa được định nghĩa hoặc không có hàm setData.");
            }

            $.ajax({
                url: "{{ url('/admin/home/filter-by-date') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    from_date: $('#datepicker').val(),
                    to_date: $('#datepicker2').val(),
                    _token: $('input[name="_token"]').val()
                },
                success: function(data) {
                    chart.setData(data);
                    console.log("Data loaded successfully.");
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
            console.log(data)

        });

        $('#dashboard-filter').change(function() {
            var dashboard_value = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('dashboard.filterByBtn') }}",
                method: "POST",
                dataType: "JSON",
                data: {
                    dashboard_value: dashboard_value,
                    _token: _token
                },
                success: function(data) {
                    chart.setData(data);
                    console.log("Data loaded successfully.");
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    console.log("Response:", xhr.responseText);
                }
            });
        });
    </script> --}}



    @if (Session::has('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ Session::get('success') }}",
            });
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "{{ Session::get('error') }}",
            });
        </script>
    @endif


    @yield('script')

</body>

</html>
