@if (!empty(session('primary')))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong> Primary! </strong> {{ session('primary') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (!empty(session('success')))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong> Thành công! </strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (!empty(session('error')))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong> Lỗi! </strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (!empty(session('warning')))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong> Warning! </strong> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@if (!empty(session('info')))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong> Info! </strong> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
