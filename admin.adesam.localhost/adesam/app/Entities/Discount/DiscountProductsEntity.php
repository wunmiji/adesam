<?php

namespace App\Entities\Discount;

readonly class DiscountProductsEntity {

    public function __construct (
        public ?int $id,
        public ?int $productId,
        public ?string $productCipherId,
        public ?string $name,

        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}