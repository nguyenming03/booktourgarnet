@extends('client.layouts.app')
@section('title')
    Tour Yêu Thích
@endsection
@section('content')
    <section class="bread-crumb margin-bottom-10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="home" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="{{ route('home') }}" title="Trang chủ">
                                <span itemprop="name">Trang chủ</span>
                                <meta itemprop="position" content="1" />
                            </a>
                            <span><i class="fa fa-angle-right"></i></span>
                        </li>

                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <strong itemprop="name">Yêu Thích</strong>
                            <meta itemprop="position" content="2" />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="container white collections-container margin-bottom-20">
        <div class="white-background">
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">
                        <div class="visible-md visible-lg">
                            <div class="shopping-cart-table">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="lbl-shopping-cart lbl-shopping-cart-gio-hang">Danh sách yêu thích
                                            <span>(<span class="count_item_pr">{{ $favorite_tours->count() }}</span>
                                                tour)</span>
                                        </h1>
                                    </div>
                                </div>
                                @if ($favorite_tours->isEmpty())
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="cart-empty">
                                                <img src="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/empty-bags6d1d.jpg?1705894518705') }}"
                                                    class="img-responsive center-block" alt="Giỏ hàng trống" />
                                                <div class="btn-cart-empty">
                                                    <a class="btn btn-default" href="{{ route('home') }}"
                                                        title="Tiếp tục mua sắm">
                                                        Tiếp tục mua sắm
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>STT</th>
                                                    <th>Tên Tour</th>
                                                    <th>Ảnh</th>
                                                    <th>Giá người lớn</th>
                                                    <th>Giá trẻ em</th>
                                                    <th>Giá sale</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $stt = 1; ?>
                                                @foreach ($favorite_tours as $item)
                                                    <tr data-id="{{ $item->id }}">
                                                        <td>{{ $stt++ }}</td>
                                                        <td><a class="line-clamp"
                                                                href="{{ route('client.tour.show', $item->tour->id) }}"
                                                                title="{{ $item->tour->name }}">{{ $item->tour->name }}</a>
                                                        </td>
                                                        <td>
                                                            <img src="{{ Storage::url($item->tour->image) }}" alt=""
                                                                width="100px">
                                                        </td>
                                                        <td>{{ number_format($item->tour->price_old, 0, '', '.') }} VNĐ
                                                        </td>
                                                        <td>{{ number_format($item->tour->price_children, 0, '', '.') }}
                                                            VNĐ
                                                        </td>
                                                        <td>{{ number_format($item->tour->price_old * (1 - $item->tour->sale / 100), 0, '', '.') }}
                                                            VNĐ</td>
                                                        <td>
                                                            <i class="fa fa-trash text-danger"
                                                                onclick="deleteFavorite({{ $item->id }})"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteFavorite(id) {
            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('favorite.delete', ':id') }}".replace(':id', id),
                        method: "DELETE",
                        dataType: "json",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            if (res.status) {
                                // Xóa dòng này trong bảng ở giao diện
                                $(`tr[data-id="${id}"]`).remove();
                                // Cập nhật số lượng
                                const count = parseInt($('.count_item_pr').text()) - 1;
                                $('.count_item_pr').text(count);

                                Swal.fire('Xóa thành công!', '', 'success');

                                // Nếu không còn tour nào, hiển thị thông báo trống
                                if (count === 0) {
                                    $('.shopping-cart-table').html(`
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 class="lbl-shopping-cart lbl-shopping-cart-gio-hang">Danh sách yêu thích
                                                <span>(<span class="count_item_pr">0</span>
                                                    tour)</span>
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="cart-empty">
                                            <img src="{{ url('client/bizweb.dktcdn.net/100/299/077/themes/642224/assets/empty-bags6d1d.jpg?1705894518705') }}" class="img-responsive center-block" alt="Giỏ hàng trống" />
                                            <div class="btn-cart-empty">
                                                <a class="btn btn-default" href="{{ route('home') }}" title="Tiếp tục mua sắm">Tiếp tục mua sắm</a>
                                            </div>
                                        </div>
                                    </div>
                                `);
                                }
                            } else {
                                Swal.fire(res.message, '', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Có lỗi xảy ra!', '', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endsection
