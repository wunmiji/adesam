<?php

namespace App\Entities\Occasion;

readonly class OccasionImageEntity {

    public function __construct (
        public ?int $id,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}