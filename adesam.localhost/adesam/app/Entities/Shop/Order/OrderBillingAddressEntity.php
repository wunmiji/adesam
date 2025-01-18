<?php

namespace App\Entities\Shop\Order;

readonly class OrderBillingAddressEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $email,
        public ?string $number,
        public ?string $addressOne,
        public ?string $addressTwo,
        public ?string $city,
        public ?string $postalCode,
        public ?string $stateName,
        public ?string $stateCode,
        public ?string $countryName,
        public ?string $countryCode
    ) {}

}