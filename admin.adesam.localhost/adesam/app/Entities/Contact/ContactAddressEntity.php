<?php

namespace App\Entities\Contact;

readonly class ContactAddressEntity {

    public function __construct (
        public ?int $id,
        public ?string $address,
        public ?string $postalCode,
        public ?string $countryName,
        public ?string $countryCode
    ) {}

}