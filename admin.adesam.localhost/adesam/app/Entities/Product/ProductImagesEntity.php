<?php

namespace App\Entities\Product;


readonly class ProductImagesEntity {

    public function __construct (
        public ?int $id,
        public ?int $productId,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,
        public ?string $fileMimetype

    ) {}

}