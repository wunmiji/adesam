<?php

namespace App\Entities\Tag;

readonly class TagEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $type,
        public ?string $slug,

    ) {}

}