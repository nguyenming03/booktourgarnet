<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Payment
 */
class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'money' => (float) $this->money,
            'note' => $this->p_note,
            'transaction' => $this->transaction,
            'code_vnpay' => $this->code_vnpay,
            'time' => optional($this->time)->toDateTimeString(),
            'payment_method' => $this->whenLoaded('paymentMethod', fn () => $this->paymentMethod->name),
            'payment_status' => $this->whenLoaded('paymentStatus', fn () => $this->paymentStatus->name),
        ];
    }
}
