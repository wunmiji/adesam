<?php

namespace App\Entities\Shop\Order;

readonly class OrderEntity {

    public function __construct (
        public ?int $id,
        public ?int $userId,
        public ?string $number,
        public ?string $status,
        public ?string $subtotal,
        public ?string $instruction,
        public ?string $total,
        public ?string $date,
        public ?string $paymentStatus,
        public ?string $deliveryStatus,

        public ?string $createdDateTime,

        public ?string $stringSubtotal,
        public ?string $stringTotal,

        public ?OrderBillingAddressEntity $billingAddress,
        public ?OrderShippingAddressEntity $shippingAddress,
        public ?array $items,
        public ?OrderShippingEntity $shipping,

    ) {}

}