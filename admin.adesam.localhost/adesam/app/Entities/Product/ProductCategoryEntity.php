<?php

namespace App\Entities\Product;

readonly class ProductCategoryEntity {

    public function __construct (
        public ?int $id,
        public ?int $categoryId,
        public ?string $categoryName,


    ) {}

}