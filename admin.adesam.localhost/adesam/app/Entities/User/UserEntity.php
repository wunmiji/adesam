<?php

namespace App\Entities\User;

readonly class UserEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $name,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public ?string $number,
        public ?string $description,

        public ?string $createdDateTime,
        public ?string $modifiedDateTime,

        public ?UserImageEntity $image,
        public ?array $billingAddresses,
        public ?array $shippingAddresses,
    ) {}

}