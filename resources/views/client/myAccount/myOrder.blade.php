@extends('client.myAccount.navAcc')
@section('navMy')
    <div id="orders" class="content-section">
        <h1 class="title-head">Đơn hàng của bạn</h1>
        <div class="my-account">
            <div class="dashboard">
                <div class="recent-orders">
                    <div class="table-responsive tab-all">
                        <table class="table table-cart table-order" id="my-orders-table">
                            <thead class="thead-default">
                                <tr>
                                    <th>Tour</th>
                                    <th>Các điểm tours</th>
                                    <th>Điểm xuất phát</th>
                                    {{-- <th>Ngày đặt</th> --}}
                                    <th>Ngày bắt đầu</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Di chuyển</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    @if ($bookTours->isEmpty())
                                        <td colspan="6">
                                            <p>Không có đơn hàng nào.</p>
                                        </td>
                                    @else
                                </tr>
                                @foreach ($bookTours as $bookTour)
                                    <tr>
                                        <td>{{ $bookTour->tour->name }}</td>
                                        <td>{{ $bookTour->tour->journeys }}</td>
                                        <td>{{ $bookTour->tour->starting_gate }}</td>
                                        <td>{{ $bookTour->start_date }}</td>
                                        <td>{{ $bookTour->status->name ?? 'chưa cập nhật' }}</td>
                                        <td>{{ number_format($bookTour->total_money) }} đ</td>
                                        <td>{{ $bookTour->tour->move_method }}</td>
                                        <td>
                                            <a href="{{ route('orders.donHangDetails', $bookTour->id) }}"
                                                class="btn btn-click btn-success" data-toggle="modal"
                                                data-target="#orderDetailModal">Xem chi tiết</a>
                                        </td>

                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade {{ isset($selectedOrder) ? 'show in' : '' }}"
                                        id="orderDetailModal" tabindex="-1" role="dialog"
                                        aria-labelledby="orderDetailModalLabel"
                                        aria-hidden="{{ isset($selectedOrder) ? 'false' : 'true' }}"
                                        style="{{ isset($selectedOrder) ? 'display: block;' : 'display: none;' }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if (isset($selectedOrder))
                                                        <p><strong>Tour:</strong> {{ $selectedOrder->tour->name }}</p>
                                                        <p><strong>Ngày bắt đầu:</strong> {{ $selectedOrder->start_date }}
                                                        </p>
                                                        <p><strong>Trạng thái:</strong>
                                                            {{ $selectedOrder->status->name ?? 'chưa cập nhật' }}</p>
                                                        <p><strong>Tổng tiền:</strong>
                                                            {{ number_format($selectedOrder->total_money) }} đ</p>
                                                        <p><strong>Phương thức di chuyển:</strong>
                                                            {{ $selectedOrder->tour->move_method }}</p>
                                                        {{-- {{$selectedOrder->id}} --}}
                                                    @else
                                                        <p>Không có chi tiết đơn hàng để hiển thị.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                    <div class="paginate-pages pull-right page-account text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
