<?php

namespace App\Entities\Shop\Product;

readonly class ProductEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $sku,
        public ?string $visibilityStatus,
        public ?string $stockStatus,
        public ?int $quantity,
        public ?float $costPrice,
        public ?float $sellingPrice,
        public ?float $actualSellingPrice,
        public ?string $unique,
        public ?string $description,

        public ?string $stringCostPrice,
        public ?string $stringSellingPrice,
        public ?string $stringActualSellingPrice,

        public ?ProductImageEntity $image,
        public ?ProductTextEntity $text,
        public ?ProductDiscountEntity $discount,
        public ?ProductCategoryEntity $category,
        public ?array $tags,
        public ?array $images,
        public ?array $additionalInformations,

    ) {}

}