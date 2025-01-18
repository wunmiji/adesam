<?php

namespace App\Entities\Family;

readonly class FamilyImageEntity {

    public function __construct (
        public ?int $id,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}