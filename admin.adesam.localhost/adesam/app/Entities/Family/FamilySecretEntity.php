<?php

namespace App\Entities\Family;

readonly class FamilySecretEntity {
    
    public function __construct(
        public ?int $id,
        public ?string $salt,
        public ?string $password,
    ) {}
}