<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .card-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .card p {
        font-size: 1rem;
        color: #555;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    strong {
        font-weight: 600;
        color: #333;
    }

    img.img-fluid {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    p {
        margin: 0;
        font-size: 1rem;
        line-height: 1.5;
        color: #666;
    }
</style>

<div class="card p-4">
    <h5 class="card-title">{{ $tour->name }}</h5>

    <div class="mb-3">
        <strong>Hình ảnh:</strong>
        <img src="{{ Storage::url($tour->image) }}" alt="Image" class="img-fluid rounded" width="100">
    </div>

    <div class="mb-3">
        <strong>Lịch trình:</strong>
        <p>{{ $tour->journeys }}</p>
    </div>

    <div class="mb-3">
        <strong>Hành trình:</strong>
        <p>{{ $tour->schedule }}</p>
    </div>

    <div class="mb-3">
        <strong>Phương tiện di chuyển:</strong>
        <p>{{ $tour->move_method }}</p>
    </div>

    <div class="mb-3">
        <strong>Số ngày:</strong>
        <p>{{ $tour->starting_gate }}</p>
    </div>

    <div class="mb-3">
        <strong>Ngày khởi hành:</strong>
        <p>{{ $tour->start_date }}</p>
    </div>

    <div class="mb-3">
        <strong>Ngày kết thúc:</strong>
        <p>{{ $tour->end_date }}</p>
    </div>

    <div class="mb-3">
        <strong>Số khách:</strong>
        <p>{{ $tour->number_guests }}</p>
    </div>

    <div class="mb-3">
        <strong>Giá người lớn:</strong>
        <p>{{ $tour->price_old }}</p>
    </div>

    <div class="mb-3">
        <strong>Giá trẻ em:</strong>
        <p>{{ $tour->price_children }}</p>
    </div>

    <div class="mb-3">
        <strong>Sale:</strong>
        <p>{{ $tour->sale }}</p>
    </div>

    <div class="mb-3">
        <strong>Lượt xem:</strong>
        <p>{{ $tour->view }}</p>
    </div>

    <div class="mb-3">
        <strong>Mô tả:</strong>
        <p>{{ $tour->description }}</p>
    </div>

    <div class="mb-3">
        <strong>Nội dung:</strong>
        <p>{!! $tour->content !!}</p>
    </div>

    <div class="mb-3">
        <strong>Địa điểm:</strong>
        <p>{{ $tour->location->name }}</p>
    </div>

    <div class="mb-3">
        <strong>Người đăng:</strong>
        <p>{{ $tour->user->name }}</p>
    </div>

    <div class="mb-3">
        <p><strong>Trạng thái:</strong>
            @if ($tour->status == 1)
                <span>Hiển Thị</span>
            @else
                <span>Ẩn</span>
            @endif
        </p>
    </div>

    <h3>Danh Mục Dịch Vụ</h3>
    <ul>
        @foreach ($tour->categoryServices as $categoryService)
            <li>
                <strong>{{ $categoryService->category_name }}</strong>
            </li>
        @endforeach
    </ul>


    <h3>Dịch Vụ Đi Kèm</h3>
    <ul>
        @foreach ($tour->services as $service)
            <li>{{ $service->name }} - {{ $service->price }} VND</li>
        @endforeach
    </ul>

    <div class="mb-3">
        <strong>Ngày đăng:</strong>
        <p>{{ $tour->created_at }}</p>
    </div>

    <div class="mb-3">
        <strong>Ngày cập nhật:</strong>
        <p>{{ $tour->updated_at }}</p>
    </div>
</div>
