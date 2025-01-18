<?php

namespace App\Entities\Product;

readonly class ProductTextEntity {

    public function __construct (
        public ?int $id,
        public ?string $text,

    ) {}

}