<?php foreach ($datas as $data): ?>
    <?php $dataImage = $data->image; ?>

    <div class="row row-gap-2">
        <div class="col-lg-4 col-md-5 col-12">
            <img class="img-fluid" src="<?= $dataImage->fileSrc; ?>" alt="<?= $dataImage->fileName; ?>">
        </div>
        <div class="col-lg-5 col-md-4 col-12 d-flex align-items-center">
            <div class="d-flex flex-column row-gap-2">
                <p class="card-text mb-0"><?= $data->publishedDate; ?></p>
                <a href="/occasions/<?= $data->slug; ?>" class="fs-2 fw-bold color-first-100"><?= $data->title; ?></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-12 d-flex align-items-center">
            <p class="card-text"><?= $data->summary; ?></p>
        </div>
    </div>
<?php endforeach; ?>