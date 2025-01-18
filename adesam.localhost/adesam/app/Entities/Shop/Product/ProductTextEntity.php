<?php

namespace App\Entities\Shop\Product;

readonly class ProductTextEntity {

    public function __construct (
        public ?int $id,
        public ?string $text,

    ) {}

}