@extends('admin.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .tour-dates-input {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .tour-dates-input:hover {
            background-color: #f0f8ff;
            border-color: #c7ced6;
        }

        .tour-dates-input:focus {
            background-color: #ffffff;
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }


        .category-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .category-item {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px 10px;
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .category-item:hover {
            box-shadow: 0px 4px 8px rgba(255, 254, 254, 0.1);
            background-color: #f0f0f0;
        }

        .category-checkbox {
            margin-right: 8px;
            accent-color: #67b66a;
            width: 18px;
            height: 18px;
        }


        .category-item label {
            font-size: 14px;
            color: #333;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .category-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .category-item {
                padding: 5px;
                font-size: 13px;
            }

            .category-checkbox {
                width: 16px;
                height: 16px;
            }
        }

        @media (max-width: 576px) {
            .category-container {
                grid-template-columns: 1fr;
            }
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
                        <h4 class="mb-sm-0">Sửa Tour</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="">Trang quản trị</a></li>
                                <li class="breadcrumb-item active">Sửa Tour</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('tour.update', $tour->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hinh_anh" class="form-label">Hình Ảnh</label>

                                            <input type="file" id="image" name="image" class="form-control"
                                                onchange="showImage(event)">

                                            @if (!empty($tour->image))
                                                <img id="img_danh_muc" src="{{ Storage::url($tour->image) }}"
                                                    alt="Hình Ảnh Sản Phẩm" style="width: 150px;">
                                            @else
                                                <img id="img_danh_muc" src="#" alt="Hình Ảnh Sản Phẩm"
                                                    style="width: 150px; display: none;">
                                            @endif
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên Tour<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="name" name="name"
                                                value="{{ old('name', $tour->name) }}" class="form-control"
                                                placeholder="Nhập tên tour...">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="journeys" class="form-label">Hành Trình<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="journeys" name="journeys"
                                                value="{{ old('journeys', $tour->journeys) }}" class="form-control"
                                                placeholder="Nhập hành trình tour...">
                                            @error('journeys')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="tourDates" class="form-label">Chọn các ngày:</label>
                                            <input type="text" id="tourDates" name="tour_dates"
                                                class="form-control tour-dates-input"
                                                value="{{ old(
                                                    'tour_dates',
                                                    isset($tour->tourDates)
                                                        ? implode(
                                                            ', ',
                                                            $tour->tourDates->pluck('tour_date')->map(function ($date) {
                                                                    return \Carbon\Carbon::parse($date)->format('d-m-Y'); // Chuyển đổi sang định dạng d-m-Y
                                                                })->unique()->toArray(),
                                                        )
                                                        : '',
                                                ) }}"
                                                readonly>
                                            @error('tour_dates')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <hr>
                                        <div id="itinerary-container" class="mb-3">
                                            @foreach ($tourLocations as $index => $location)
                                                <div class="itinerary">
                                                    <br>
                                                    <div class="row">
                                                        <label>Lịch trình {{ $index + 1 }}</label>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="locations">Chọn điểm đến:</label>
                                                                <select name="locations[{{ $index }}][start]"
                                                                    class="form-control">

                                                                    <option value="{{ $location->start }}" selected>
                                                                        {{ $location->start }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            @error('locations.*.start')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label for="end-location">Điểm kết thúc:</label>
                                                                <select name="locations[{{ $index }}][end]"
                                                                    class="form-control">
                                                                    <option value="{{ $location->end }}" selected>
                                                                        {{ $location->end }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            @error('locations.*.end')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description">Mô tả lịch trình:</label>
                                                        <textarea name="locations[{{ $index }}][description]" class="form-control">{{ $location->description }}</textarea>

                                                    </div>
                                                    <button type="button" class="btn btn-danger remove-itinerary"
                                                        data-id="{{ $location->id }}">Xóa lịch trình</button>
                                                </div>
                                            @endforeach

                                            <br>
                                            <button type="button" class="btn btn-success add-itinerary">Thêm lịch
                                                trình</button>
                                        </div>


                                        <hr>
                                        <div class="mb-3">
                                            <label for="category_services">Chọn danh mục dịch vụ:</label>
                                            <div id="category_services" class="category-container">
                                                @foreach ($categoryServices as $category)
                                                    <div class="category-item">
                                                        <input type="checkbox" name="category_services[]"
                                                            value="{{ $category->id }}" class="category-checkbox"
                                                            {{ in_array($category->id, $tour->categoryServices->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                        <label>{{ $category->category_name }}</label>
                                                    </div>
                                                @endforeach
                                                @error('category_services')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="services">Chọn dịch vụ đi kèm:</label>
                                            <select name="services[]" id="services" class="form-control" multiple>
                                                @foreach ($tour->services as $service)
                                                    <option value="{{ $service->id }}" selected>{{ $service->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('services')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>



                                        <script>
                                            document.querySelectorAll('.category-checkbox').forEach(checkbox => {
                                                checkbox.addEventListener('change', function() {
                                                    const selectedCategories = Array.from(document.querySelectorAll(
                                                            '.category-checkbox:checked'))
                                                        .map(checkbox => checkbox.value);

                                                    const currentSelectedServices = Array.from(document.querySelectorAll(
                                                            '#services option:checked'))
                                                        .map(option => option.value);

                                                    fetch('/admin/api/get-services-by-categories', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                            },
                                                            body: JSON.stringify({
                                                                category_ids: selectedCategories
                                                            })
                                                        })
                                                        .then(response => response.json())
                                                        .then(data => {
                                                            const servicesSelect = document.getElementById('services');
                                                            servicesSelect.innerHTML = ''; // Clear existing options

                                                            const newServiceIds = new Set(data.services.map(service => service.id
                                                                .toString()));

                                                            data.services.forEach(service => {
                                                                const option = document.createElement('option');
                                                                option.value = service.id;
                                                                option.textContent = service.name;
                                                                if (currentSelectedServices.includes(service.id.toString())) {
                                                                    option.selected = true;
                                                                }
                                                                servicesSelect.appendChild(option);
                                                            });
                                                        })
                                                        .catch(error => console.error('Error:', error));
                                                });
                                            });
                                        </script>
                                        <hr>
                                        <div class="mb-3">
                                            <label for="schedule" class="form-label">Lịch Trình<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="schedule" name="schedule"
                                                value="{{ $tour->schedule }}" class="form-control"
                                                placeholder="Nhập lịch trình tour...">

                                        </div>

                                        <div class="mb-3">
                                            <label for="number" class="form-label">Số Lượng Chuyến Tour<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="number" name="number"
                                                value="{{ $tour->number }}" class="form-control"
                                                placeholder="Nhập số lượng chuyến tour...">
                                            @error('number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="move_method" class="form-label">Phương Tiện Di Chuyển<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="move_method" name="move_method"
                                                value="{{ $tour->move_method }}" class="form-control"
                                                placeholder="Nhập phương tiện di chuyển">
                                            @error('move_method')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="starting_gate" class="form-label">Điểm khởi hành<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="starting_gate" name="starting_gate"
                                                value="{{ $tour->starting_gate }}" class="form-control"
                                                placeholder="Nhập điểm khởi hành...">
                                            @error('starting_gate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="description">Mô tả ngắn</label>
                                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Nhập mô tả tour...">{{ $tour->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-label">
                                                <label for="details">Nội dung chi tiết</label>
                                                <textarea id="editor" name="content">{{ $tour->content }}</textarea>
                                                @error('content')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="start_date" class="form-label">Ngày Bắt Đầu<span
                                                            class="text-danger">*</span></label>
                                                    <input type="datetime-local" id="start_date" name="start_date"
                                                        value="{{ $tour->start_date }}" class="form-control"
                                                        placeholder="Enter instructor name">
                                                    @error('start_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="end_date" class="form-label">Ngày Kết Thúc<span
                                                            class="text-danger">*</span></label>
                                                    <input type="datetime-local" id="end_date" name="end_date"
                                                        value="{{ $tour->end_date }}" class="form-control"
                                                        placeholder="Lessons">
                                                    @error('end_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="time" class="form-label">Số ngày diễn ra<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" id="time" name="time"
                                                        value="{{ $tour->time }}" class="form-control"
                                                        placeholder="Số ngày diễn ra.Ví dụ 3 ngày 2 đêm số điền vào sẽ là 3">
                                                    @error('time')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="price_old" class="form-label">Giá cũ<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" id="price_old" name="price_old"
                                                        value="{{ $tour->price_old }}" class="form-control"
                                                        placeholder="Mời nhập giá...">
                                                    @error('price_old')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="price_children" class="form-label">Giá trẻ em<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" id="price_children" name="price_children"
                                                        value="{{ $tour->price_children }}" class="form-control"
                                                        placeholder="Nhập giá trẻ em...">
                                                    @error('price_children')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="sale" class="form-label">Giảm Giá<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" id="sale" name="sale"
                                                        value="{{ $tour->sale }}" class="form-control"
                                                        placeholder="Nhập giá khuyến mãi...">
                                                    @error('sale')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="number_guests" class="form-label">Số lượng khách tối
                                                        đa<span class="text-danger">*</span></label>
                                                    <input type="number" id="number_guests" name="number_guests"
                                                        value="{{ $tour->number_guests }}" class="form-control"
                                                        placeholder="Nhập số lượng khách...">
                                                    @error('number_guests')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div><!--end col-->

                                            <div class="mb-3 col-6">
                                                <label for="status1" class="form-label">Địa điểm<span
                                                        class="text-danger">*</span></label>
                                                <select name="location_id" class="form-select w-100" id="status1">
                                                    <option value="">Chọn địa điểm</option>
                                                    @foreach ($listlocation as $status)
                                                        <option value="{{ $status->id }}"
                                                            {{ $tour->location_id == $status->id ? 'selected' : '' }}>
                                                            {{ $status->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('location_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-6">
                                                <label for="status1" class="form-label">Mục Tour<span
                                                        class="text-danger">*</span></label>
                                                <select name="category_tour_id" class="form-select w-100" id="status1">
                                                    <option value="">Chọn Mục Tour</option>
                                                    @foreach ($listCategoryTour as $status)
                                                        <option value="{{ $status->id }}"
                                                            {{ $tour->category_tour_id == $status->id ? 'selected' : '' }}>
                                                            {{ $status->category_tour }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_tour_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3 col-6" hidden>
                                                <label for="user_id" class="form-label">Người thực hiện<span
                                                        class="text-danger">*</span></label>
                                                <input type="hidden" name="user_id" id="user_id"
                                                    value="{{ Auth::user()->id }}"> <!-- Input ẩn để lưu user ID -->
                                                <input type="text" class="form-control w-100"
                                                    value="{{ Auth::user()->name }}" disabled>
                                                <!-- Hiển thị tên người dùng -->
                                                {{-- @error('user_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror --}}
                                            </div>


                                            <div class="mb-3 col-6">
                                                <label for="status1" class="form-label">Trạng Thái<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="status1" name="status">
                                                    {{-- <option value="">Trạng Thái</option> --}}
                                                    <option value="1" selected>Hiển Thị</option>
                                                    <option value="0">Ẩn</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hinh_anh" class="form-label">Album hình ảnh</label>
                                                <i id="add-row"
                                                    class="mdi mdi-plus text-muted fs-18 rounded-2 border ms-3 p-1"
                                                    style="cursor: pointer"></i>
                                                <table class="table align-middle table-nowrap mb-0">
                                                    <tbody id="image-table-body">
                                                        @foreach ($tour->imagetour as $index => $hinhAnh)
                                                            <tr>
                                                                <td class="d-flex align-item-center">
                                                                    <img id="preview_{{ $index }}"
                                                                        src="{{ Storage::url($hinhAnh->image) }}"
                                                                        alt="Hình Ảnh SẢn Phẩm" style="width: 50px"
                                                                        class="me-3">
                                                                    <input type="file" id="image"
                                                                        name="list_hinh_anh[{{ $hinhAnh->id }}]"
                                                                        class="form-control"
                                                                        onchange="previewImage(this,{{ $index }})">
                                                                    <input type="hidden"
                                                                        name="list_hinh_anh[{{ $hinhAnh->id }}]"
                                                                        value="{{ $hinhAnh->id }}">

                                                                </td>
                                                                <td>
                                                                    <i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"
                                                                        style="cursor: pointer"></i>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>

                                                </table>
                                                @error('list_hinh_anh')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 10px">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="submit">Cập nhật</button>
                                        <a href="{{ route('tour.index') }}" class="btn btn-danger">Hủy</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#services').select2({
                placeholder: "Chọn các dịch vụ",
                allowClear: true
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itineraryCount = {{ $tourLocations->count() ?? 1 }}; // Số lịch trình hiện có

            const container = document.getElementById('itinerary-container');
            const addButton = document.querySelector('.add-itinerary');

            // Hàm tải danh sách tỉnh thành từ cities.json
            function loadCities(selectElement) {
                fetch('/cities.json') // Đường dẫn đến file JSON
                    .then(response => response.json())
                    .then(data => {
                        data.cities.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city;
                            option.textContent = city;
                            selectElement.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Lỗi khi tải cities.json:', error));
            }

            // Hàm thêm lịch trình mới
            addButton.addEventListener('click', function() {
                itineraryCount++;
                const newItinerary = document.createElement('div');
                newItinerary.classList.add('itinerary');
                newItinerary.innerHTML = `
            <br>
            <label>Lịch trình ${itineraryCount}</label>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="locations">Chọn điểm đến:</label>
                        <select name="locations[${itineraryCount - 1}][start]" class="form-control">
                            <option value="">Chọn địa điểm...</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="end-location">Điểm kết thúc:</label>
                        <select name="locations[${itineraryCount - 1}][end]" class="form-control">
                            <option value="">Chọn địa điểm...</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description">Mô tả lịch trình:</label>
                <textarea name="locations[${itineraryCount - 1}][description]" class="form-control"></textarea>
            </div>
            <button type="button" class="btn btn-danger remove-itinerary">Xóa lịch trình</button>
        `;

                container.appendChild(newItinerary);

                const startSelect = newItinerary.querySelector(
                    `select[name="locations[${itineraryCount - 1}][start]"]`);
                const endSelect = newItinerary.querySelector(
                    `select[name="locations[${itineraryCount - 1}][end]"]`);


                loadCities(startSelect);
                loadCities(endSelect);


                newItinerary.querySelector('.remove-itinerary').addEventListener('click', function() {
                    newItinerary.remove();
                });
            });

            // Tải dữ liệu cho các lịch trình đã có
            const existingStartSelects = document.querySelectorAll('select[name^="locations"][name$="[start]"]');
            const existingEndSelects = document.querySelectorAll('select[name^="locations"][name$="[end]"]');
            existingStartSelects.forEach(loadCities);
            existingEndSelects.forEach(loadCities);
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".remove-itinerary").on('click', function() {
                let id = $(this).data('id');
                let parentEl = $(this).parent();
                parentEl.remove()
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#tourDates", {
            mode: "multiple",
            dateFormat: "d-m-Y",
            locale: "vi",
            onChange: function(selectedDates, dateStr, instance) {
                document.getElementById("tourDates").value = dateStr;
            }
        });
    </script>
    <script>
        function showImage(event) {
            const img_danh_muc = document.getElementById('img_danh_muc');

            const file = event.target.files[0];

            const reader = new FileReader();

            reader.onload = function() {
                img_danh_muc.src = reader.result;
                img_danh_muc.style.display = 'block';


            }
            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
    {{-- Thêm album ảnh --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var rowCount = 1;

            document.getElementById('add-row').addEventListener('click', function() {
                var tableBody = document.getElementById('image-table-body');
                var newRow = document.createElement('tr');
                newRow.innerHTML = `
         <td class="d-flex align-item-center">
        <img id="preview_${rowCount}" src="https://static.vecteezy.com/system/resources/previews/000/420/681/original/picture-icon-vector-illustration.jpg" alt="Hình Ảnh SẢn Phẩm"
        style="width: 50px" class="me-3">
        <input type="file" id="hinh_anh" name="list_hinh_anh[id_${rowCount}]" class="form-control"
        onchange="previewImage(this,${rowCount})">
    
    
    
    </td>
    <td>
        <i 
            class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1" style="cursor: pointer" onclick="removeRow(this)"></i>
    </td>`;
                tableBody.appendChild(newRow);
                rowCount++;

            })



        });

        function previewImage(input, rowIndex) {

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById(`preview_${rowIndex}`).setAttribute('src', e.target.result)


                }

                reader.readAsDataURL(input.files[0]);

            }

        }

        function removeRow(item) {
            var row = item.closest('tr');
            row.remove();
        }
        CKEDITOR.replace('content');
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '/upload-image?_token={{ csrf_token() }}',
                },
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                    'blockQuote', '|', 'insertTable', 'uploadImage', '|', 'undo', 'redo'
                ],
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side'],
                },
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script src="https:////cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
@endsection
