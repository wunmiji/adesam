<?php

namespace App\Entities\Contact;

readonly class ContactTagsEntity {

    public function __construct (
        public ?int $id,
        public ?int $tagId,
        public ?int $contactId,
        public ?string $tagName
    ) {}

}