<?php

namespace App\Entities\Shop\Product;

readonly class ProductDiscountEntity {

    public function __construct (
        public ?int $id,
        public ?int $discountId,
        public ?string $discountName,
        public ?string $discountType,
        public ?int $discountValue,

        public ?string $stringDiscount,


    ) {}

}