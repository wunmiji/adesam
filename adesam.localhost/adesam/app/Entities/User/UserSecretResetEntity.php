<?php

namespace App\Entities\User;

readonly class UserSecretResetEntity {
    
    public function __construct(
        public ?int $id,
        public ?string $token,
        public ?string $expiresAt,
    ) {}
}