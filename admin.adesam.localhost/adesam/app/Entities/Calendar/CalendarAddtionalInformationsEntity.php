<?php

namespace App\Entities\Calendar;

readonly class CalendarAddtionalInformationsEntity {

    public function __construct (
        public ?int $id,
        public ?int $calendarId,
        public ?string $field,
        public ?string $label,

    ) {}

}