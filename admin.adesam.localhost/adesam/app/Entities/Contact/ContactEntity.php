<?php

namespace App\Entities\Contact;

readonly class ContactEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $nickname,
        public ?string $type,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $gender,
        public ?string $email,
        public ?string $description,
        public ?string $mobile,
        public ?string $dob,

        public ?string $dobString,

        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?ContactImageEntity $image,
        public ?ContactAddressEntity $address,
        public ?array $tags,
        public ?array $additionalInformations,
        
        
    ) {}

}