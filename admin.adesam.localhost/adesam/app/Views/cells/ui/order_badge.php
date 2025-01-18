<?php if ($status == \App\Enums\OrderStatus::NEW->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OrderStatus::NEW->color() ?>">
        <?= \App\Enums\OrderStatus::NEW->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OrderStatus::IN_PROGRESS->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OrderStatus::IN_PROGRESS->color() ?>">
        <?= \App\Enums\OrderStatus::IN_PROGRESS->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OrderStatus::PAID->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OrderStatus::PAID->color() ?>">
        <?= \App\Enums\OrderStatus::PAID->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OrderStatus::PARTIAL_PAID->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OrderStatus::PARTIAL_PAID->color() ?>">
        <?= \App\Enums\OrderStatus::PARTIAL_PAID->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OrderStatus::COMPLETED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OrderStatus::COMPLETED->color() ?>">
        <?= \App\Enums\OrderStatus::COMPLETED->value; ?>
    </span>
<?php elseif ($status == \App\Enums\OrderStatus::CANCELLED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\OrderStatus::CANCELLED->color() ?>">
        <?= \App\Enums\OrderStatus::CANCELLED->value; ?>
    </span>
<?php endif ?>