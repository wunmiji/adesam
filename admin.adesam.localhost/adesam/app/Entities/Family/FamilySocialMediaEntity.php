<?php

namespace App\Entities\Family;

readonly class FamilySocialMediaEntity {

    public function __construct (
        public ?int $id,
        public ?string $facebook,
        public ?string $instagram,
        public ?string $linkedin,
        public ?string $twitter,
        public ?string $youtube,
    ) {}

}