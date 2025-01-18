<?php

namespace App\Entities\Product;

readonly class ProductTagsEntity {

    public function __construct (
        public ?int $id,
        public ?int $productId,
        public ?int $tagId,
        public ?string $tagName,


    ) {}

}