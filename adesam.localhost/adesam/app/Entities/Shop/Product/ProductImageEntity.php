<?php

namespace App\Entities\Shop\Product;

readonly class ProductImageEntity {

    public function __construct (
        public ?int $id,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}