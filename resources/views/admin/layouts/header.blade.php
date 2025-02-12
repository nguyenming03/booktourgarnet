<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt="" height="22">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/assets/images/logo-light.png') }}" alt="" height="22">
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                
            </div>

            <div class="d-flex align-items-center">

              

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bi bi-arrows-fullscreen fs-lg'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('admin/assets/images/users/32/avatar-1.jpg') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name ??'Guest'}}</span>
                                <span class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">
                                    @if (Auth::user()->role_id == 1 )
                                        Admin
                                    @endif
                                    
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}</h6>
                        <a class="dropdown-item" href="pages-profile.html"><i
                                class="mdi mdi-account-circle text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="apps-chat.html"><i
                                class="mdi mdi-message-text-outline text-muted fs-lg align-middle me-1"></i>
                            <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="apps-tickets-overview.html"><i
                                class="mdi mdi-calendar-check-outline text-muted fs-lg align-middle me-1"></i>
                            <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="pages-faqs.html"><i
                                class="mdi mdi-lifebuoy text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages-profile.html"><i
                                class="mdi mdi-wallet text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Balance : <b>$8451.36</b></span></a>
                        <a class="dropdown-item" href="pages-profile-settings.html"><span
                                class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                                class="mdi mdi-cog-outline text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="auth-lockscreen.html"><i
                                class="mdi mdi-lock text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Lock screen</span></a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i
                                class="mdi mdi-logout text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-4"></i>
                    </div>
                    <div class="mt-4 fs-base">
                        <h4 class="mb-1">Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                        It!</button>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="removeCartModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-cartmodal"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-5"></i>
                    </div>
                    <div class="mt-4">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this product ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-cartproduct">Yes, Delete
                        It!</button>
                </div>
            </div>
        </div>
    </div>
</div>
