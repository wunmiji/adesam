<?php

namespace App\Entities\Order;

readonly class OrderItemsEntity {

    public function __construct (
        public ?int $id,
        public ?int $orderId,
        public ?string $orderCipherId,
        public ?string $orderNumber,
        public ?string $orderDate,
        public ?int $productId,
        public ?string $productCipherId,
        public ?string $productName,
        public ?string $productUnique,
        public ?int $quantity,
        public ?float $price,
        public ?float $total,

        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

        public ?string $stringPrice,
        public ?string $stringTotal,

    ) {}

}