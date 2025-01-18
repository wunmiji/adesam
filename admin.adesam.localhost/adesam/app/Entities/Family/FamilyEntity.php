<?php

namespace App\Entities\Family;

readonly class FamilyEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $name,
        public ?string $firstName,
        public ?string $middleName,
        public ?string $lastName,
        public ?string $role,
        public ?string $email,
        public ?string $mobile,
        public ?string $telephone,
        public ?string $gender,
        public ?string $dob,
        public ?string $description,

        public ?string $createdDateTime,
        public ?string $modifiedDateTime,

        public ?FamilySocialMediaEntity $socialMedia,
        public ?FamilyImageEntity $image,
        public ?FamilySecretEntity $secret
    ) {}

}