<?php

namespace App\Entities\Shop\Product;

readonly class ProductAddtionalInformationsEntity {

    public function __construct (
        public ?int $id,
        public ?int $productId,
        public ?string $field,
        public ?string $label,

    ) {}

}