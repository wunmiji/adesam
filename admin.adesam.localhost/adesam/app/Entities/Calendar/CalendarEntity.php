<?php

namespace App\Entities\Calendar;

readonly class CalendarEntity {

    public function __construct (
        public ?int $id,
        public ?string $cipherId,
        public ?string $title,
        public ?string $type,
        public ?bool $isLocked,
        public ?bool $isRecurring,
        public ?int $startYear,
        public ?int $startMonth,
        public ?int $startDay,
        public ?string $startTime,
        public ?int $endYear,
        public ?int $endMonth,
        public ?int $endDay,
        public ?string $endTime,
        public ?string $description,
        public ?string $backgroundColor,

        public ?string $recurringType,
        public ?string $start,
        public ?string $end,

        public ?string $stringStart,
        public ?string $stringEnd,
        public ?string $stringStartTime,
        public ?string $stringEndTime,

        public ?int $createdId,
        public ?string $createdBy,
        public ?string $createdDateTime,

        public ?int $modifiedId,
        public ?string $modifiedBy,
        public ?string $modifiedDateTime,

        public ?CalendarImageEntity $image,
        public ?array $extendedProps,
        
        
    ) {}

}