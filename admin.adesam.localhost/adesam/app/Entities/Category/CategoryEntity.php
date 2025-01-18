<?php

namespace App\Entities\Category;

readonly class CategoryEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $name,
        public ?string $slug,
        public ?int $countProducts,
        public ?string $description,
        public ?string $date,

        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?CategoryImageEntity $image,
        public ?CategoryTextEntity $text,

    ) {}

}