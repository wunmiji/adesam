<?php

namespace App\Entities\Setting;

readonly class SettingEntity {

    public function __construct (
        public ?int $id,
        public ?string $category,
        public ?string $key,
        public ?string $value,

    ) {}

}