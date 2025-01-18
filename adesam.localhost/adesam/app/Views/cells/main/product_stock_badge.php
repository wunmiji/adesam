<?php if ($status == \App\Enums\ProductStockStatus::IN_STOCK->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\ProductStockStatus::IN_STOCK->color() ?>">
        <?= \App\Enums\ProductStockStatus::IN_STOCK->value; ?>
    </span>
<?php elseif ($status == \App\Enums\ProductStockStatus::OUT_OF_STOCK->name): ?>
    <span class="badge" style="background-color: <?= \App\Enums\ProductStockStatus::OUT_OF_STOCK->color() ?>">
        <?= \App\Enums\ProductStockStatus::OUT_OF_STOCK->value; ?>
    </span>
<?php endif ?>