<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable"
    data-theme="default" data-topbar="light" data-bs-theme="light">

<head>

    <meta charset="utf-8">
    <title>404 Error | School Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    <!-- Fonts css load -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link id="fontsLink"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- Layout config Js -->
    <script src="{{ asset('admin/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ asset('admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">

</head>

<body>

    <section
        class="auth-page-wrapper py-5 position-relative d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card mb-0">
                        <div class="row g-0 align-items-center">

                            <!--end col-->
                            <div class="col-xxl-6 mx-auto">
                                <div class="card mb-0 border-0 shadow-none mb-0">
                                    <div class="card-body p-sm-5 m-lg-4">
                                        <div class="error-img text-center px-5">
                                            <img src="{{ asset('admin/assets/images/auth/404.png') }}" class="img-fluid"
                                                alt="">
                                        </div>
                                        <div class="mt-4 text-center pt-3">
                                            <div class="position-relative">
                                                <h4 class="fs-2xl error-subtitle text-uppercase mb-0">Rất tiếc, trang
                                                    này không tồn tại.</h4>

                                                <div class="mt-4">
                                                    <a href="{{ route('home-admin') }}" class="btn btn-primary"><i
                                                            class="mdi mdi-home me-1"></i>Quay lại</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>

</body>


<!-- Mirrored from themesbrand.com/steex/layouts/auth-404.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 13 Sep 2024 11:35:57 GMT -->

</html>
