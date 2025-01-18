<?php

namespace App\Entities\Category;

readonly class CategoryTextEntity {

    public function __construct (
        public ?int $id,
        public ?string $text,

    ) {}

}