<?php

namespace App\Entities\User;

readonly class UserAddressEntity {

    public function __construct (
        public ?int $id,
        public ?int $userId,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public ?string $number,
        public ?string $addressOne,
        public ?string $addressTwo,
        public ?string $city,
        public ?string $postalCode,
        public ?string $stateName,
        public ?string $stateCode,
        public ?string $countryName,
        public ?string $countryCode,

        public ?string $createdDateTime,
    ) {}

}