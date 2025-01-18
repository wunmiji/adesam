<?php if ($status == \App\Enums\ProductVisibilityStatus::HIDDEN->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\ProductVisibilityStatus::HIDDEN->color() ?>">
        <?= \App\Enums\ProductVisibilityStatus::HIDDEN->value; ?>
    </span>
<?php elseif ($status == \App\Enums\ProductVisibilityStatus::PUBLISHED->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\ProductVisibilityStatus::PUBLISHED->color() ?>">
        <?= \App\Enums\ProductVisibilityStatus::PUBLISHED->value; ?>
    </span>
<?php endif ?>