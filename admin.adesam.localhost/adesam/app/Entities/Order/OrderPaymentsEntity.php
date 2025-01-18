<?php

namespace App\Entities\Order;

readonly class OrderPaymentsEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?int $orderId,
        public ?string $orderCipherId,
        public ?string $name,
        public ?string $orderNumber,
        public ?float $amount,
        public ?string $status,
        public ?string $method,

        public ?string $stringAmount,

        public ?string $createdDateTime,

    ) {}

}