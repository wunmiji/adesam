<?php

namespace App\Entities\Shop\Cart;

readonly class CartItemsEntity {

    public function __construct (
        public ?int $id,
        public ?int $cartId,
        public ?int $productId,
        public ?int $quantity,
        public ?string $productUnique,
        public ?string $productName,
        public ?float $productPrice,
        public ?float $total,

        public ?string $stringProductPrice,
        public ?string $stringTotal,

        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}