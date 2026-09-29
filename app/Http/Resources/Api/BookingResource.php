<?php

namespace App\Http\Resources\Api;

use App\Models\Admins\DonTour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\BookTour
 */
class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'date_booking' => optional($this->date_booking)->toDateTimeString(),
            'start_date' => optional($this->start_date)->toDateTimeString(),
            'end_date' => optional($this->end_date)->toDateTimeString(),
            'note' => $this->note,
            'number_old' => (int) $this->number_old,
            'number_children' => (int) $this->number_children,
            'total_money' => (float) $this->total_money,
            'status' => [
                'code' => $this->status,
                'label' => DonTour::TRANG_THAI_TOUR[$this->status] ?? $this->status,
            ],
            'cancel_reason' => $this->ly_do_huy,
            'tour' => new TourResource($this->whenLoaded('tour')),
            'payment' => new PaymentResource($this->whenLoaded('pay')),
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
