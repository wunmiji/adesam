<?php

namespace App\Entities\Discount;

readonly class DiscountEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $type,
        public ?string $name,
        public ?int $value,

        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?string $stringDiscount,

        public ?array $products,
    ) {}

}