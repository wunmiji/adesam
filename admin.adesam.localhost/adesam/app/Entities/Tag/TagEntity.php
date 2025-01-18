<?php

namespace App\Entities\Tag;

readonly class TagEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $name,
        public ?string $type,
        public ?string $slug,

        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?array $contacts,
        public ?array $products,
        public ?array $occasions,
    ) {}

}