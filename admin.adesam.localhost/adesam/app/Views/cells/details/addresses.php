<div class="row my-3">
    <div class="col-12">
        <div class="card" style="max-height: 25rem;">
            <div class="card-header card-header-title"><?= $title; ?></div>
            <div class="card-body overflow-y-auto">
                <?php if (empty($dataAdresses)): ?>
                    <small>No data yet</small>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($dataAdresses as $key => $dataAddress): ?>
                            <div class="col-lg-3 col-md-4 col-6">
                                <address>
                                    <p class="fs-6 fw-semibold">
                                        <?= $dataAddress->firstName . ' ' . $dataAddress->lastName; ?>
                                    </p>
                                    <p class="mb-0"><?= $dataAddress->addressOne . ','; ?></p>
                                    <?php if (!is_null($dataAddress->addressTwo)): ?>
                                        <p class="mb-0"><?= $dataAddress->addressTwo . ','; ?></p>
                                    <?php endif; ?>
                                    <p class="mb-0">
                                        <?= $dataAddress->city . ', ' . $dataAddress->stateCode . ' ' . $dataAddress->postalCode; ?>
                                    </p>
                                    <p class="mb-2"><?= $dataAddress->countryName . '.'; ?></p>

                                    <p class="mb-0"><?= $dataAddress->number; ?></p>
                                    <p class="mb-0"><?= $dataAddress->email; ?></p>
                                    <small class="mb-0"><?= $dataAddress->createdDateTime; ?></small>
                                </address>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>