<?php

namespace App\Http\Resources\Api;

use App\Models\Admins\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Admins\Tour
 */
class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $salePercent = (int) ($this->sale ?? 0);
        $priceOld = (float) $this->price_old;
        $priceSale = round($priceOld * (1 - $salePercent / 100));

        return [
            'id' => $this->id,
            'name' => $this->name,
            'journeys' => $this->journeys,
            'schedule' => $this->schedule,
            'move_method' => $this->move_method,
            'starting_gate' => $this->starting_gate,
            'start_date' => optional($this->start_date)->toDateTimeString(),
            'end_date' => optional($this->end_date)->toDateTimeString(),
            'number_guests' => (int) $this->number_guests,
            'number_remaining' => (int) $this->number,
            'price' => [
                'old' => $priceOld,
                'sale_percent' => $salePercent,
                'final' => $priceSale,
                'children' => $this->price_children !== null ? (float) $this->price_children : null,
            ],
            'thumbnail' => $this->image,
            'description' => $this->description,
            'content' => $this->content,
            'status' => (bool) $this->status,
            'rating' => [
                'average' => round((float) Review::where('tour_id', $this->id)->avg('rating'), 1),
                'count' => Review::where('tour_id', $this->id)->count(),
            ],
            'category' => new CategoryResource($this->whenLoaded('category_tour')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'schedule_items' => $this->whenLoaded('tourLocations', function () {
                return $this->tourLocations->map(fn ($item) => [
                    'start' => $item->start,
                    'end' => $item->end,
                    'description' => $item->description,
                ]);
            }),
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
