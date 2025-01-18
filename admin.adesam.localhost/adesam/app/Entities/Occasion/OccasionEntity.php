<?php

namespace App\Entities\Occasion;

readonly class OccasionEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $title,
        public ?string $slug,
        public ?string $summary,
        public ?string $status,
        public ?string $publishedDate,
        
        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?OccasionImageEntity $image,
        public ?OccasionTextEntity $text,
        public ?OccasionAuthorEntity $author,
        public ?array $tags,
        public ?array $medias

    ) {}

}