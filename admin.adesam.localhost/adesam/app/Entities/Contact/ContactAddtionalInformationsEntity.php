<?php

namespace App\Entities\Contact;

readonly class ContactAddtionalInformationsEntity {

    public function __construct (
        public ?int $id,
        public ?int $contactId,
        public ?string $field,
        public ?string $label,

    ) {}

}