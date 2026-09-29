<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tour_id' => $this->tour_id,
            'name' => $this->name,
            'code' => $this->code,
            'percentage_price' => (float) $this->percentage_price,
            'type' => $this->type,
            'number' => (int) $this->number,
            'status' => (bool) $this->status,
            'start_date' => optional($this->start_date)->toDateTimeString(),
            'end_date' => optional($this->end_date)->toDateTimeString(),
            'days_remaining' => $this->end_date
                ? max(0, (int) Carbon::now()->diffInDays(Carbon::parse($this->end_date), false))
                : null,
            'tour' => new TourResource($this->whenLoaded('tour')),
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
