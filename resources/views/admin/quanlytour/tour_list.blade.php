<tbody class="list form-check-all" id="tour-table-body">
    @if ($listTour->isEmpty())
        <tr>
            <td colspan="11" class="text-center text-muted">
                Trống.
            </td>
        </tr>
    @else
        @foreach ($listTour as $index => $item)
            <tr>
                <td><a href="" class="text-reset">{{ $item->id }}</a></td>
                <td>{{ $item->booking->user->name ?? 'Ẩn Danh' }}</td>

                <td>{{ $item->booking->tour->name ?? 'Tour đã bị xóa' }}</td>

                <td>{{ $item->booking->name }}</td>
                <td>{{ \Carbon\Carbon::parse($item->booking->start_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->booking->end_date)->format('d/m/Y') }}</td>
                <td>{{ $item->booking->phone ?? 'Không có' }}</td>
                
                <td>
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}
                </td>
                <td>
                    @if ($item->paymentMethod->id == 1)
                        VNPAY
                    @elseif ($item->paymentMethod->id == 2)
                        Momo
                    @elseif ($item->paymentMethod->id == 3)
                        Thẻ Ngân Hàng
                    @elseif ($item->paymentMethod->id == 4)
                        Thanh Toán Trực Tiếp
                    @endif
                </td>
                <td>
                    <select id="payment-status-select" name="payment_status_id"
                        class="form-select w-full max-w-xs payment-status-select status-tour"
                        data-id="{{ $item->id }}"
                        data-default-value="{{ $item->payment_status_id }}"
                        @if ($item->payment_status_id == 3) disabled @endif>
                        @foreach ($trangThaiThanhToan as $key => $value)
                            <option value="{{ $key }}"
                                {{ $key == $item->payment_status_id ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select id="status-select" name="status_id"
                        class="form-select w-full max-w-xs status status-tour"
                        data-id="{{ $item->id }}"
                        data-default-value="{{ $item->status_id }}"
                        @if ($item->status_id == 13 || $item->status_id == 13) disabled @endif>
                        @foreach ($trangThaiTour as $key => $value)
                            <option value="{{ $key }}"
                                {{ $key == $item->status_id ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>


                    <ul class="d-flex gap-2 list-unstyled mb-0">
                        <li>
                            <a class="btn btn-subtle-primary btn-icon btn-sm view-quanlytour"
                                data-id="{{ $item->id }}">
                                <i class="ph-eye"></i>
                            </a>
                        </li>

                        {{-- <li>
                        <a href="#deleteRecordModal{{ $item->id }}"
                            data-bs-toggle="modal"
                            class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"><i
                                class="ph-trash"></i></a>
                    </li> --}}
                    </ul>
                </td>
            </tr>
        @endforeach
    @endif
</tbody