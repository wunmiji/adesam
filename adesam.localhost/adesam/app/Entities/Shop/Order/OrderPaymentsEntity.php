<?php

namespace App\Entities\Shop\Order;

readonly class OrderPaymentsEntity {

    public function __construct (
        public ?int $id,
        public ?int $orderId,
        public ?string $name,
        public ?string $orderNumber,
        public ?float $amount,
        public ?string $status,
        public ?string $method,

        public ?string $stringAmount,

        public ?string $createdDateTime,

    ) {}

}