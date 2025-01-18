<?php

namespace App\Entities\Order;

readonly class OrderEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?int $userId,
        public ?string $userCipherId,
        public ?string $number,
        public ?string $subtotal,
        public ?string $instruction,
        public ?float $total,
        public ?string $date,
        public ?string $userName,
        public ?string $userEmail,
        public ?string $userNumber,
        public ?int $countItems,

        public ?string $status,
        public ?string $paymentStatus,
        public ?string $deliveryStatus,

        public ?string $createdDateTime,
        public ?string $modifiedDateTime,

        public ?string $stringSubtotal,
        public ?string $stringTotal,

        public ?array $items,
        public ?array $payments,
        public ?OrderShippingEntity $shipping,
        public ?OrderBillingAddressEntity $billingAddress,
        public ?OrderShippingAddressEntity $shippingAddress,
        

    ) {}

}