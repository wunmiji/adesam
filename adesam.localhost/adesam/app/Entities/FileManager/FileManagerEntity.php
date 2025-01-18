<?php

namespace App\Entities\FileManager;

readonly class FileManagerEntity {

    public function __construct (
        public ?int $id,
        public ?string $privateId,
        public ?string $publicId,
        public ?string $name,
        public ?string $urlPath,
        public ?string $path,
        public ?string $parentPath,

    ) {}

}