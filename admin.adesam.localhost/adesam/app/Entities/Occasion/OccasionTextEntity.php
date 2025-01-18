<?php

namespace App\Entities\Occasion;

readonly class OccasionTextEntity {

    public function __construct (
        public ?int $id,
        public ?string $text,

    ) {}

}