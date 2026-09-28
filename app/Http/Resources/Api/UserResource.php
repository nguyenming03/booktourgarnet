<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'avatar' => $this->avatar,
            'birth' => $this->birth,
            'gender' => $this->gender,
            'status' => (int) $this->status,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}
