<?php

namespace App\Entities\Occasion;


readonly class OccasionMediaEntity {

    public function __construct (
        public ?int $id,
        public ?int $occasionId,
        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,
        public ?string $fileMimetype

    ) {}

}