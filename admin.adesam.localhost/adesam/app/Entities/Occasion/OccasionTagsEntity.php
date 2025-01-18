<?php

namespace App\Entities\Occasion;

readonly class OccasionTagsEntity {

    public function __construct (
        public ?int $id,
        public ?int $eventId,
        public ?int $tagId,
        public ?string $tagName,


    ) {}

}