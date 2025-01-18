<?php

namespace App\Entities\User;

readonly class UserSecretEntity {
    
    public function __construct(
        public ?int $id,
        public ?string $salt,
        public ?string $password,
    ) {}
}