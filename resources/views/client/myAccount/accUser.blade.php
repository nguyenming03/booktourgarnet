@extends('client.myAccount.navAcc')
@section('navMy')
    <div id="account-info" class="content-section">
        <h1 class="title-head">Thông tin tài khoản</h1>
        <div class="my-account">
            <div class="dashboard">
                <div class="recent-orders">
                    <div class="table-responsive tab-all">
                        <div class="form-signup name-account m992">
                            <table class="table table-cart table-order" id="my-orders-table">
                                <thead class="thead-default">
                                    <tr>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p>{{ $user->name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $user->phone ?? 'Bạn chưa cập nhật số điện thoại' }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $user->address ?? 'Bạn chưa cập nhật địa chỉ' }}</p>
                                        </td>
                                        <td>
                                            <p><a class="btn btn-success" href="{{route('my-account.edit',$user->id)}}">Chỉnh sửa tài khoản</a></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
