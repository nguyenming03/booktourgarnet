<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->category_tour,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => (bool) $this->status,
            'responsibility' => $this->responsibility,
            'tours_count' => $this->when(isset($this->tours_count), $this->tours_count),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}
