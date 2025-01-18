<?php

namespace App\Entities\Calendar;

readonly class CalendarContactEntity {

    public function __construct (
        public ?int $id,
        public ?int $contactId,
        public ?bool $dob,

        public ?string $calendarCipherId,
        public ?string $calendarTitle,
        public ?string $calendarBackgroundColor,

        public ?string $calendarStart,
        public ?string $calendarEnd,

        public ?string $calendarStringStart,
        public ?string $calendarStringEnd,

        public ?string $calendarStringStartTime,
        public ?string $calendarStringEndTime,

        public ?int $fileId,
        public ?string $fileSrc,
        public ?string $fileName,

    ) {}

}