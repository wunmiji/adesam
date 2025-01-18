<?php

namespace App\Entities\Tag;

readonly class TagContactsEntity {

    public function __construct (
        public ?int $id,
        public ?int $contactId,
        public ?string $contactCipherId,
        public ?string $nickname,

        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}