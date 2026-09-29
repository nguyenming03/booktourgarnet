<?php

namespace App\Services;

use App\Models\User;

/**
 * DTO trả về từ CustomerResolver::resolve().
 */
class ResolvedCustomer
{
    public function __construct(
        public readonly ?int $customerId,
        public readonly ?int $userId,
        public readonly ?string $temporaryUserId,
        public readonly ?User $user,
    ) {
    }

    public function isGuest(): bool
    {
        return is_null($this->userId);
    }
}
