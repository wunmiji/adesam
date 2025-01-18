<?php

namespace App\Entities\Contact;

readonly class ContactNumberEntity {

    public function __construct (
        public ?int $id,
        public ?string $mobile,
        public ?string $home,
        public ?string $work
    ) {}

}