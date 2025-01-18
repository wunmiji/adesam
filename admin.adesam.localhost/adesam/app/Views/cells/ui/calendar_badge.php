<?php if ($type == \App\Enums\CalendarType::BIRTHDAY->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\CalendarType::BIRTHDAY->color() ?>">
        <?= \App\Enums\CalendarType::BIRTHDAY->value; ?>
    </span>
<?php elseif ($type == \App\Enums\CalendarType::EVENT->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\CalendarType::EVENT->color() ?>">
        <?= \App\Enums\CalendarType::EVENT->value; ?>
    </span>
<?php elseif ($type == \App\Enums\CalendarType::HOLIDAY->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\CalendarType::HOLIDAY->color() ?>">
        <?= \App\Enums\CalendarType::HOLIDAY->value; ?>
    </span>
<?php endif ?>