<!-- corousel -->
<div class="pt-4">
    <div class="container py-4">
        <div class="row py-5">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center ">
                    <h1 class="mb-0 fw-bold"><?= $dataCarouselTitle; ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 justify-content-end align-items-center">
                            <?php foreach ($dataCarouselBreadCrumb as $key => $value): ?>
                                <li class="breadcrumb-item" style="font-size: 1.1rem"><a href="<?= $key; ?>">
                                        <?= $value; ?>
                                    </a></li>
                            <?php endforeach; ?>
                            <li class="breadcrumb-item active" style="font-size: 1.1rem" aria-current="page">
                                <?= $dataCarouselBreadCrumbActive; ?>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <hr class="my-0">
    </div>
</div>