<div class="d-flex flex-column">
    <div class="d-flex justify-content-between">
        <div class="fw-bold fs-5">
            <?= $title; ?>
        </div>
        <div class="d-flex flex-wrap column-gap-2">
            <?php if (isset($buttons)): ?>
                <?php foreach ($buttons as $value): ?>
                    <?= $value; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
</div>