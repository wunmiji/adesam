<?php

namespace App\Entities\User;

readonly class UserEntity {

    public function __construct (
        public ?int $id,
        public ?string $name,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $email,
        public ?string $mobile,
        public ?string $description,

        public ?string $createdDateTime,
        public ?string $modifiedDateTime,

        public ?UserImageEntity $image,
        public ?UserSecretEntity $secret,
        public ?array $billingAddress,
        public ?array $shippingAddress,

    ) {}

}