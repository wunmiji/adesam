<?php

namespace App\Entities\Shop\Cart;

readonly class CartEntity {

    public function __construct (
        public ?int $id,
        public ?int $userId,
        public ?string $shippingType,
        public ?string $paymentMethod,


        public ?array $items,

    ) {}

}