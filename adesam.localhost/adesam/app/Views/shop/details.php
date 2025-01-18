<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
    'dataCarouselTitle' => 'Product',
    'dataCarouselBreadCrumb' => ['/' => 'Home', '/shop' => 'Shop'],
    'dataCarouselBreadCrumbActive' => $data->unique,
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<?php if ($data->visibilityStatus == \App\Enums\ProductVisibilityStatus::PUBLISHED->name): ?>
    <div class="mb-5 row g-5">
        <div class="col-md-5 col-12">
            <div class="card">
                <div class="product-image-div">
                    <img src="<?= $dataImage->fileSrc; ?>" class="card-img-top" id="product-featured-image"
                        alt="<?= $dataImage->fileName; ?>">
                </div>
                <div class="card-body px-0">
                    <!-- Swiper <i class='bx bx-chevron-left bx-sm'></i> <i class='bx bx-chevron-right bx-sm'></i> -->
                    <div class="swiper product-image-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($dataImages as $eachDataImages): ?>
                                <div class="swiper-slide product-image-div">
                                    <img src="<?= $eachDataImages->fileSrc; ?>" name="product-image" class="card-img-top"
                                        alt="<?= $eachDataImages->fileName; ?>" role="button">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-12">
            <div class="d-flex flex-column row-gap-4">
                <?php $dataCategory = $data->category; ?>
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/"><i class="bx bx-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/shop">Shop</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Detail
                            </li>
                        </ol>
                    </nav>

                    <?= view_cell('\App\Cells\MainCell::productStockBadge', ['status' => $data->stockStatus]) ?>
                </div>
                <div>
                    <h1 class="fw-medium mb-0"><?= $data->name; ?></h1>
                </div>
                <div>
                    <p class="mb-0"><?= $data->description; ?></p>
                </div>
                <div class="d-flex column-gap-3">
                    <?php if ($data->sellingPrice != $data->actualSellingPrice): ?>
                        <del class="fs-5 text-body-secondary"><?= $data->stringSellingPrice ?></del>
                    <?php endif; ?>
                    <h4 class="fw-medium mb-0 color-first-100">
                        <?= $data->stringActualSellingPrice ?>
                    </h4>
                </div>
                <div class="d-flex align-items-center column-gap-3">
                    <h6 class="mb-0">Stock : </h6>
                    <p class="mb-0"><?= $data->quantity; ?></p>
                </div>
                <div class="d-flex align-items-center column-gap-3">
                    <h6 class="mb-0">Quantity :</h6>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn primary-outline-btn px-3" id="minus-btn">
                            <i class='bx bx-minus'></i>
                        </button>
                        <button class="btn primary-outline-btn px-4" id="quantity" style="cursor: default;">1</button>
                        <button type="button" class="btn primary-outline-btn px-3" id="plus-btn">
                            <i class='bx bx-plus'></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex column-gap-3">
                    <button class="btn primary-btn px-5" id="addToCart"
                        <?= ($data->stockStatus == \App\Enums\ProductStockStatus::OUT_OF_STOCK->name) ? 'disabled' : ''; ?>
                        data-currency="<?= esc($currency); ?>" data-product-unique="<?= $data->unique; ?>"
                        data-product-price="<?= $data->actualSellingPrice; ?>"
                        data-string-product-price="<?= $data->stringActualSellingPrice; ?>"
                        data-product-image-src="<?= $dataImage->fileSrc; ?>" data-product-id="<?= $data->id; ?>"
                        data-product-image-alt="<?= $dataImage->fileName; ?>" data-product-name="<?= $data->name; ?>">Add to
                        Cart</button>
                </div>
                <div>
                    <div class="d-flex column-gap-3">
                        <p class="mb-0 fw-medium">SKU :</p>
                        <p class="mb-0"><?= $data->sku; ?></p>
                    </div>
                    <div class="d-flex column-gap-3">
                        <a class="fs-6 fw-medium">Category :</a>
                        <a href="/shop/categories/<?= $dataCategory->categorySlug; ?>"
                            class="fs-6"><?= $dataCategory->categoryName; ?></a>
                    </div>
                    <?php if (!empty($dataTags)): ?>
                        <div class="d-flex">
                            <a class="fs-6 fw-medium">Tags :</a>
                            <?php $tagCommaArray = []; ?>
                            <?php foreach ($dataTags as $dataTag): ?>
                                <?php array_push($tagCommaArray, '<a href="/shop/tags/' . $dataTag->tagSlug . '" class="fs-6">' . $dataTag->tagName . '</a>'); ?>
                            <?php endforeach; ?>
                            <?php $tagCommaOutput = implode(',&nbsp;', $tagCommaArray); ?>
                            <?= $tagCommaOutput; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <div class="mb-5 row">
        <div class="col">
            <ul class="nav justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description"
                        aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-additional-information-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-additional-information" type="button" role="tab"
                        aria-controls="pills-additional-information" aria-selected="false">Additional Information</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-enquiry-tab" data-bs-toggle="pill" data-bs-target="#pills-enquiry"
                        type="button" role="tab" aria-controls="pills-enquiry" aria-selected="false">Enquiry</button>
                </li>

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                    aria-labelledby="pills-description-tab" tabindex="0"><?= $dataText->text; ?></div>
                <div class="tab-pane fade" id="pills-additional-information" role="tabpanel"
                    aria-labelledby="pills-additional-information-tab" tabindex="0">
                    <?php if (empty($dataAdditionalInformations)): ?>
                        <small>No data yet</small>
                    <?php else: ?>
                        <div class="d-flex gap-3">
                            <table class="table table-borderless">
                                <tbody>
                                    <?php foreach ($dataAdditionalInformations as $key => $dataAdditionalInformation): ?>
                                        <tr>
                                            <td class="fw-medium w-25"><?= $dataAdditionalInformation->field; ?></td>
                                            <td><?= $dataAdditionalInformation->label; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="pills-enquiry" role="tabpanel" aria-labelledby="pills-enquiry-tab"
                    tabindex="0">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8 col-sm-10 col-12">
                            <?= view_cell('\Cells\AlertCell::contact'); ?>
                            <?php $validation = \Config\Services::validation(); ?>
                            <?php if (session()->has('userId')): ?>
                                <form id="enquiry-form" action="/shop/<?= $data->unique; ?>" method="POST">
                                    <input type="hidden" name="unique" value="<?= $data->unique; ?>" />
                                    <div class="row row-cols-1">
                                        <div class="col mb-4">
                                            <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                                                rows="5" placeholder="Message"></textarea>
                                            <?php if ($validation->getError('message')): ?>
                                                <span class="text-danger text-sm">
                                                    <?= $error = $validation->getError('message'); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col">
                                            <button type="submit" name="submit" id="submit-enquiry"
                                                class="btn primary-btn w-100">Submit
                                                Enquiry</button>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form id="enquiry-form" action="/shop/<?= $data->unique; ?>" method="POST">
                                    <div class="row row-cols-1">
                                        <div class="col mb-4">
                                            <input type="text" class="form-control" id="nameInput" placeholder="Name"
                                                name="name">
                                        </div>

                                        <div class="col mb-4">
                                            <input type="email" class="form-control" id="emailInput" placeholder="Email"
                                                name="email">
                                        </div>

                                        <div class="col mb-4">
                                            <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                                                rows="5" placeholder="Message"></textarea>
                                        </div>

                                        <div class="col">
                                            <button type="submit" name="submit" id="submit-enquiry"
                                                class="btn primary-btn w-100">Submit
                                                Enquiry</button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif ($data->visibilityStatus == \App\Enums\ProductVisibilityStatus::HIDDEN->name): ?>
    <div class="mb-5 row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="d-flex flex-column row-gap-3 text-center">
                <h1 class="fw-medium mb-0"><?= $data->name; ?></h1>
                <p>The product is no longer available.</p>
                <a href="/shop" class="btn primary-btn m-auto">RETURN TO SHOP</a>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php if (!empty($dataRelated)): ?>
    <div class="mb-5">
        <?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Related Products']); ?>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-1 row-cols-1 justify-content-center g-3">
            <?= view_cell('\Cells\MainCell::products', ['datas' => $dataRelated]); ?>
        </div>
    </div>
<?php endif; ?>



<?= $this->endSection(); ?>