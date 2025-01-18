<?php

namespace App\Entities\User;

readonly class UserCookieEntity {
    
    public function __construct(
        public ?int $id,
        public ?int $userId,
        public ?string $selector,
        public ?string $hashedValidator,
        public ?string $expires,
    ) {}
}