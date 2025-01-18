<?php

namespace App\Entities\Occasion;

readonly class OccasionTagsEntity {

    public function __construct (
        public ?int $id,
        public ?int $occasionId,
        public ?int $tagId,
        public ?string $tagName,
        public ?string $tagSlug,


    ) {}

}