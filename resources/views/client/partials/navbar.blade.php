<?php
use App\Models\Notification;
// Lấy thông báo
$notifications = collect(); // Tạo một collection rỗng mặc định
$unreadNotifications = collect(); // Thông báo chưa đọc
$user = auth()->user();

if ($user) {
    $notifications = Notification::query()
        ->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id); // Lấy thông báo dành riêng cho người dùng
        })
        ->where('is_active', 1) // Chỉ lấy thông báo đang hoạt động
        ->orderByDesc('created_at') // Sắp xếp thông báo mới nhất
        ->get();

    // Lấy thông báo chưa đọc
    $unreadNotifications = Notification::query()
        ->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('is_read', 0); // Chỉ lấy thông báo chưa đọc
        })
        ->where('is_active', 1)
        ->orderByDesc('created_at')
        ->get();
}
?>
<style>
    .notification-popup {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 350px;
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        z-index: 1000;
        animation: slide-in 0.3s ease;
    }

    .notification-body {
        flex-grow: 1;
        overflow-y: auto;
        padding: 10px;
        max-height: 270px;
        min-height: 50px;
    }

    .notification-body p {
        margin: 0;
        padding: 10px;
        text-align: start;
        color: #999;
    }

    .notification-footer {
        padding: 10px;
        background-color: #f9f9f9;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: center;
    }

    .notification-footer .btn {
        font-size: 14px;
        border-radius: 20px;
    }

    @keyframes slide-in {
        from {
            transform: translateY(100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
<nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="nav" class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                    @foreach ($categoryes as $category)
                        <li class="nav-item {{ $category->children->isNotEmpty() ? 'has-mega' : '' }}">
                            <a class="nav-link" href="{{ route('home.allTour') }}">
                                {{ $category->name }}
                                @if ($category->children->isNotEmpty())
                                    <i class="fa fa-angle-right"></i>
                                @endif
                            </a>

                            @if ($category->children->isNotEmpty())
                                <div class="mega-content" style="width: 15% !important;">
                                    <div class="level0-wrapper2">
                                        <div class="nav-block nav-block-center">
                                            <ul class="level0"
                                                style="display: flex; flex-direction: column; padding: 0; margin: 0; list-style: none;">

                                                @foreach ($category->children as $child)
                                                    <li class="level1 parent item" style="margin-bottom: 10px;">
                                                        <h2 class="h4" style="margin: 0;">
                                                            <a href="{{ url('tour/' . $child->slug) }}"
                                                                style="text-decoration: none; color: #333;">
                                                                <span>{{ $child->name }}</span>
                                                            </a>
                                                        </h2>
                                                        @if ($child->children->isNotEmpty())
                                                            <ul class="level1"
                                                                style="padding-left: 20px; list-style: none;">
                                                                @foreach ($child->children as $subChild)
                                                                    <li class="level2" style="margin-bottom: 5px;">
                                                                        <a href="{{ url('tour/' . $subChild->slug) }}"
                                                                            style="text-decoration: none; color: #555;">
                                                                            <span>{{ $subChild->name }}</span>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach

                    <!-- Các menu tĩnh -->
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('home.allTour') }}">Tất cả Tour</a></li> --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('introduce.index') }}">Giới thiệu</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cam-nang-dul-lich">Cẩm nang du lịch</a>
                    </li>
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('handbook.index') }}">Cẩm nang du lịch</a></li> --}}

                    <li class="nav-item"><a class="nav-link" href="{{ route('contact.index') }}">Liên hệ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('favorite.index') }}">Yêu
                            Thích</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('maGiamGia.index') }}">Mã Giảm Giá</a>
                    </li>

                </ul>

            </div>
        </div>
    </div>
</nav>
<!-- Modal hiển thị thông báo -->
@if (Auth()->user())
    <div class="notification-popup" id="notificationPopup" style="display: none">
        <div class="notification-header">
            <h4>Thông Báo Mới Nhận</h4>
        </div>
        @if ($notifications->isEmpty())
            <div class="notification-body">
                <p class="title col-3" style="text-align: center">Không có thông báo mới</p>
            </div>
        @else
            <div class="notification-body">

                @foreach ($notifications as $notification)
                    <div class="notification-item">
                        <div class="notification-content">
                            @if ($notification->title == 'Thông báo hoàn tiền')
                                <p class="title col-3" style="color: red">{{ $notification->title }}</p>
                                <p class="description" style="color: red">- {{ $notification->content }}</p>
                                <p class="notification-time" style="color: rgb(0, 0, 0); text-align: end">
                                    {{ $notification->created_at->format('d-m-Y') }}</p>
                                <hr style="border: 0.02rem  solid rgb(156, 156, 156)">
                            @else
                                <p class="title col-3" style="color: blue">{{ $notification->title }}</p>
                                <p class="description" style="color: blue">- {{ $notification->content }}</p>
                                <p class="notification-time" style="color: rgb(7, 7, 7); text-align: end">
                                    {{ $notification->created_at->format('d-m-Y') }}</p>
                                <hr style="border: 0.02rem  solid rgb(156, 156, 156)">
                            @endif

                        </div>
                    </div>
                @endforeach


            </div>
            <div class="notification-footer text-center">
                <button class="btn btn-md btn-primary mark-all-read" id="markAllRead">Đọc Tất Cả</button>
            </div>
        @endif
    </div>
@else
    <div class="notification-popup" id="notificationPopup" style="display: none">
        <div class="notification-header">
            <h4>Thông Báo Mới Nhận</h4>
        </div>
        <div class="notification-body">
            <p class="title col-3">Vui lòng đăng nhập để xem thông báo</p>
        </div>
    </div>
@endif
