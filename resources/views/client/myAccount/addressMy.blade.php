@extends('client.myAccount.navAcc')
@section('navMy')
    <div id="addresses" class="content-section">
        <h1 class="title-head">Địa chỉ của bạn</h1>
        <div class="my-account">
            <div class="dashboard">
                <div class="recent-orders">
                    <div class="table-responsive tab-all">
                        {{-- <p class="btn-row">
        <button class="btn-edit-addr btn btn-blues btn-more" type="button">Thêm địa chỉ</button>
    </p>
    <div id="add_address" class="form-list modal_address modal">
        <div class="btn-close closed_pop"><i class="fa fa-times"></i></div>
        <h2 class="title_pop">
            Thêm địa chỉ mới
        </h2>
        <form method="post" action="" id="customer_address" accept-charset="UTF-8"><input
                name="FormType" type="hidden" value="customer_address" /><input name="utf8"
                type="hidden" value="true" />
            <div class="pop_bottom">
                <div class="form_address">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="field">
                                <fieldset class="form-group">
                                    <label>Họ tên</label>
                                    <input type="text" placeholder="Họ tên" name="FullName"
                                        class="form-control" value=""
                                        autocapitalize="words">
                                </fieldset>
                                <p class="error-msg"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field">
                                <fieldset class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="number" placeholder="Số điện thoại"
                                        class="form-control" id="Phone" pattern="\d+"
                                        name="Phone" maxlength="12" value="">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="field">
                                <fieldset class="form-group">
                                    <label>Công ty</label>
                                    <input type="text" placeholder="Công ty" class="form-control"
                                        name="Company" value="">
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field">
                                <fieldset class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" placeholder="Địa chỉ" class="form-control"
                                        name="Address1" value="">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <fieldset class="form-group select-field">
                            <label>Quốc gia</label>
                            <select name="Country" class="form-control vn-fix add" id="mySelect1"
                                data-default="Việt Nam">
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="China">China</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Vatican">Vatican</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Wales">Wales</option>
                                <option value="Western Sahara">Western Sahara</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                                <option value="Taiwan">Taiwan</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="group-country">
                        <fieldset class="form-group select-field not-vn">
                            <label>Tỉnh thành</label>
                            <select name="Province" value="" class="form-control add"
                                id="mySelect2"></select>
                        </fieldset>
                        <fieldset class="form-group select-field not-vn">
                            <label>Quận huyện</label>
                            <select name="District" class="form-control add" value=""
                                id="mySelect3"></select>
                        </fieldset>
                        <fieldset class="form-group select-field not-vn">
                            <label>Phường xã</label>
                            <select name="Ward" class="form-control add" value=""
                                id="mySelect4"></select>
                        </fieldset>
                    </div>
                    <div class="field">
                        <fieldset class="form-group">
                            <label>Mã Zip</label>
                            <input type="text" placeholder="Mã Zip" class="form-control"
                                name="Zip" value="">
                        </fieldset>
                    </div>
                </div>
                <div class="checkbox margin-bottom-10">
                    <label class="c-input c-checkbox" style="padding-left: 20px;">
                        <input type="checkbox" id="address_default_address_" name="IsDefault"
                            value="true">
                        <span class="c-indicator">Đặt là địa chỉ mặc định?</span>
                    </label>
                </div>
                <div class="btn-row">
                    <button class="btn btn-lg btn-dark-address btn-outline article-readmore btn-close"
                        type="button"><span>Hủy</span></button>
                    <button class="btn btn-lg btn-submit btn-blues" id="addnew"
                        type="submit"><span>Thêm địa chỉ</span></button>
                </div>
            </div>
        </form>
    </div>
    end? --}}
                        <button class="btn-edit-addr btn btn-blues btn-more" type="button" data-toggle="modal"
                            data-target="#addAddressModal">
                            Thêm địa chỉ
                        </button>
                        <div class="form-signup name-account m992">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert" id="successAlert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Thành công!</strong> {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Lỗi!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <script>
                                setTimeout(function() {
                                    $('#successAlert').fadeOut('slow');
                                }, 3000);
                                setTimeout(function() {
                                    $('#errorAlert').fadeOut('slow');
                                }, 3000);
                            </script>
                            <table class="table table-cart table-order">
                                <thead class="thead-default">
                                    <tr>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="addAddressModal" class="modal fade" tabindex="-1" role="dialog"
                            aria-labelledby="addAddressLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title align-items-end justify-content-center" id="addAddressLabel">
                                            Thêm địa chỉ mới</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('user.address') }}"
                                            id="yourFormID customer_address" accept-charset="UTF-8">
                                            @csrf
                                            <input name="FormType" type="hidden" value="customer_address" />
                                            <input name="utf8" type="hidden" value="true" />

                                            <div class="form-group">
                                                <label>Họ tên</label>
                                                <input type="text" placeholder="Họ tên" name="name"
                                                    class="form-control" value="{{ auth()->user()->name }}">
                                                {{-- @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror --}}
                                            </div>

                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="number" placeholder="Số điện thoại" class="form-control"
                                                    name="phone" maxlength="12">
                                                {{-- @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror --}}
                                            </div>

                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <input type="text" placeholder="Địa chỉ" class="form-control"
                                                    name="address">
                                            </div>

                                            <div class="form-group">
                                                <label>Mã Zip</label>
                                                <input type="text" placeholder="Mã Zip" class="form-control"
                                                    name="zip">
                                            </div>

                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="IsDefault" value="true"> Đặt là địa
                                                    chỉ mặc định
                                                </label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-primary">Thêm địa chỉ</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row total_address">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
