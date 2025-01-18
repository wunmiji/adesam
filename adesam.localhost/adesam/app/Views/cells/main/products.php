<?php foreach ($datas as $data): ?>
    <?php $dataImage = $data->image; ?>
    <div class="col">
        <div class="card shop-product-card">
            <div class="product-image-div">
                <img src="<?= $dataImage->fileSrc; ?>" class="card-img-top" alt="<?= $dataImage->fileName; ?>">
            </div>
            <div class="card-body px-0 d-flex flex-column justify-content-center row-gap-3">
                <a class="fs-5 fw-medium text-center" href="/shop/<?= $data->unique; ?>"><?= $data->name; ?></a>
                <div class="d-flex justify-content-center align-items-center column-gap-2">
                    <?php if ($data->sellingPrice != $data->actualSellingPrice): ?>
                        <small class="text-body-secondary text-decoration-line-through">
                            <?= $data->stringSellingPrice ?>
                        </small>
                    <?php endif; ?>
                    <h5 class="color-first-100"><?= $data->stringActualSellingPrice ?></h5>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>