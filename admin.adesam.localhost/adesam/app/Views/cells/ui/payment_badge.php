<?php if ($status == \App\Enums\PaymentStatus::COMPLETED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\PaymentStatus::COMPLETED->color() ?>">
        <?= \App\Enums\PaymentStatus::COMPLETED->value; ?>
    </span>
<?php elseif ($status == \App\Enums\PaymentStatus::PARTIAL->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\PaymentStatus::PARTIAL->color() ?>">
        <?= \App\Enums\PaymentStatus::PARTIAL->value; ?>
    </span>
<?php elseif ($status == \App\Enums\PaymentStatus::PENDING->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\PaymentStatus::PENDING->color() ?>">
        <?= \App\Enums\PaymentStatus::PENDING->value; ?>
    </span>
<?php endif ?>