<?php if ($status == \App\Enums\OccasionStatus::DRAFT->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OccasionStatus::DRAFT->color() ?>">
        <?= \App\Enums\OccasionStatus::DRAFT->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OccasionStatus::PUBLISHED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OccasionStatus::PUBLISHED->color() ?>">
        <?= \App\Enums\OccasionStatus::PUBLISHED->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OccasionStatus::ARCHIVED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OccasionStatus::ARCHIVED->color() ?>">
        <?= \App\Enums\OccasionStatus::ARCHIVED->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OccasionStatus::SCHEDULED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OccasionStatus::SCHEDULED->color() ?>">
        <?= \App\Enums\OccasionStatus::SCHEDULED->value; ?>
    </span>
<?php endif ?>