<?php

namespace App\Entities\Order;

readonly class OrderShippingEntity {

    public function __construct (
        public ?int $id,
        public ?string $type,
        public ?float $price,

        public ?string $stringPrice,

    ) {}

}