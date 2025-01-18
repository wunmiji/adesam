<?php

namespace App\Entities\Family;

readonly class FamilySecretResetEntity {
    
    public function __construct(
        public ?int $id,
        public ?string $token,
        public ?string $expiresAt,
    ) {}
}