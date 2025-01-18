<?php

namespace App\Entities\Category;

readonly class CategoryEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $slug,
        public ?string $countProducts,
        public ?string $description,
        public ?string $date,

        public ?CategoryImageEntity $image,
        public ?CategoryTextEntity $text,

    ) {}

}