<address>
    <p class="fs-6 fw-semibold">
        <?= $dataAddress->name; ?>
    </p>
    <p class="mb-0"><?= $dataAddress->addressOne . ','; ?></p>
    <?php if (!is_null($dataAddress->addressTwo)): ?>
        <p class="mb-0"><?= $dataAddress->addressTwo . ','; ?></p>
    <?php endif; ?>
    <p class="mb-0"><?= $dataAddress->city . ', ' . $dataAddress->stateCode . ' ' . $dataAddress->postalCode; ?></p>
    <p class="mb-2"><?= $dataAddress->countryName . '.'; ?></p>

    <p class="mb-0"><?= $dataAddress->number; ?></p>
    <p class="mb-0"><?= $dataAddress->email; ?></p>
</address>