occasion<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
    'dataCarouselTitle' => 'Occasion',
    'dataCarouselBreadCrumb' => ['/' => 'Home', '/occasions' => 'Occasions'],
    'dataCarouselBreadCrumbActive' => 'Occasion',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<div class="container mb-5">
    <div class="row justify-content-center row-gap-4">
        <div class="col-lg-12 col-12">
            <div class="row row-gap-2">
                <div class="col-lg-3 col-12 px-0">
                    <p><?= $data->publishedDate; ?></p>
                    <h1 class="mb-3 fw-bold"><?= $data->title; ?></h1>
                    <div class="d-flex column-gap-2">
                        <?php $baseUrl = "/occasions/" . $data->slug; ?>
                        <a class="secondary-light-text-color" target="_blank" title="Share post via Facebook"
                            href="https://www.facebook.com/share.php?u=<?= $baseUrl; ?>">
                            <i class='bx bxl-facebook-circle first-color-hover' style="font-size: 1.25rem;"></i>
                        </a>
                        <?php $twitterLink = 'https://twitter.com/intent/tweet/?text=' . $data->title . '&url=' . $baseUrl ?>
                        <a class="secondary-light-text-color" title="Share post via Twitter"
                            href="<?= $twitterLink; ?>">
                            <i class='bx bxl-twitter first-color-hover' style="font-size: 1.25rem;"></i>
                        </a>
                        <a class="secondary-light-text-color" target="_blank"
                            href="mailto:?subject=<?= $data->title; ?>&body=<?= $baseUrl; ?>"
                            title="Share post via Email">
                            <i class='bx bx-envelope first-color-hover' style="font-size: 1.25rem;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-12 px-0">
                    <img src="<?= $dataImage->fileSrc; ?>" class="img-fluid" alt="<?= $dataImage->fileName; ?>">
                </div>
            </div>
        </div>

        <div class="col-lg-10 col-12">
            <div class="card">
                <div class="card-body px-0 mt-2 d-flex flex-column row-gap-1">
                    <div class="fs-5"><?= $dataText->text; ?></div>
                    <div class="d-flex justify-content-between flex-wrap">
                        <p class="mb-0 fs-5">Tags:</p>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <?php foreach ($dataTags as $dataTag): ?>
                                <a href="/occasions/tags/<?= $dataTag->tagSlug; ?>">
                                    <span class="badge badge-label"><?= $dataTag->tagName; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($dataMedias)): ?>
            <div class="col-lg-10 col-12">
                <div class="card">
                    <div class="card-header">
                        <?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Media']); ?>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-lg-5 row-cols-md-3 row-cols-2 g-3">
                            <?php foreach ($dataMedias as $key => $dataMedia): ?>
                                <div class="col">
                                    <div class="w-100 h-100 position-relative">
                                        <?php if (str_starts_with($dataMedia->fileMimetype, 'image')): ?>

                                            <img class="object-fit-cover" role="button" data-bs-toggle="modal"
                                                data-bs-target="#viewModal" style="width: inherit; height: inherit;"
                                                data-src="<?= $dataMedia->fileSrc; ?>" data-name="<?= $dataMedia->fileName; ?>"
                                                data-mime="<?= $dataMedia->fileMimetype; ?>" src="<?= $dataMedia->fileSrc; ?>"
                                                alt="<?= $dataMedia->fileName; ?>">

                                        <?php elseif (str_starts_with($dataMedia->fileMimetype, 'video')): ?>

                                            <video class="object-fit-cover" role="button" data-bs-toggle="modal"
                                                data-bs-target="#viewModal" style="width: inherit; height: inherit;"
                                                data-src="<?= $dataMedia->fileSrc; ?>" data-name="<?= $dataMedia->fileName; ?>"
                                                data-mime="<?= $dataMedia->fileMimetype; ?>">
                                                <source src="<?= $dataMedia->fileSrc; ?>" type="<?= $dataMedia->fileMimetype; ?>">
                                                <?= $dataMedia->fileName; ?>
                                            </video>
                                            <i class='bx bx-play-circle bx-lg position-absolute top-50 start-50 translate-middle white-color'
                                                style="pointer-events: none;"></i>

                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-10 col-12">
            <div class="card">
                <div class="card-header">
                    <?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Comments']); ?>
                </div>
                <div class="card-body">
                    <?php if (session()->has('userId')): ?>
                        <div id="comments" class="d-flex flex-column mb-2" data-base-url="<?= base_url(); ?>"></div>
                        <div id="firstCommentForm" data-slug="<?= $data->slug; ?>" data-uuid="<?= $uuid; ?>"></div>
                    <?php else: ?>
                        <p class="card-text text-center m-0 fs-5">Log in to view comments</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- view_modal -->
<?= $this->include('include/view_modal'); ?>

<?= $this->endSection(); ?>