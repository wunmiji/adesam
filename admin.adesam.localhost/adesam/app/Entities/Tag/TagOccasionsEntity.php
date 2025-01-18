<?php

namespace App\Entities\Tag;

readonly class TagOccasionsEntity {

    public function __construct (
        public ?int $id,
        public ?int $occasionId,
        public ?string $occasionCipherId,
        public ?string $title,

        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}