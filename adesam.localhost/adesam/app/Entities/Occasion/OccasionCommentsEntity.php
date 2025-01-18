<?php

namespace App\Entities\Occasion;

readonly class OccasionCommentsEntity {

    public function __construct (
        public ?int $id,
        public ?int $occasionId,
        public ?int $userId,
        public ?string $parentId,
        public ?string $childId,
        public ?string $comments,
        public ?string $name,
        public ?string $replies,

        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

        public ?string $createdDateTime,

    ) {}

}