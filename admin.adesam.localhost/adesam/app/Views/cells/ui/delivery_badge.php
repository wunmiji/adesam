<?php if ($status == \App\Enums\DeliveryStatus::PENDING->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::PENDING->color() ?>">
        <?= \App\Enums\DeliveryStatus::PENDING->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::PROCESSING->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::PROCESSING->color() ?>">
        <?= \App\Enums\DeliveryStatus::PROCESSING->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::DELIVERED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::DELIVERED->color() ?>">
        <?= \App\Enums\DeliveryStatus::DELIVERED->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::CANCEL->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::CANCEL->color() ?>">
        <?= \App\Enums\DeliveryStatus::CANCEL->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::RETURN->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::RETURN->color() ?>">
        <?= \App\Enums\DeliveryStatus::RETURN->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::DISPATCHED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::DISPATCHED->color() ?>">
        <?= \App\Enums\DeliveryStatus::DISPATCHED->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::ON_DELIVERY->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::ON_DELIVERY->color() ?>">
        <?= \App\Enums\DeliveryStatus::ON_DELIVERY->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::DECLINED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::DECLINED->color() ?>">
        <?= \App\Enums\DeliveryStatus::DECLINED->value; ?>
    </span>
<?php elseif ($status == \App\Enums\DeliveryStatus::CONFIRMED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\DeliveryStatus::CONFIRMED->color() ?>">
        <?= \App\Enums\DeliveryStatus::CONFIRMED->value; ?>
    </span>
<?php endif ?>