<div class="row pt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header position-relative p-0 details-card-header">
                <div class="details-cover-image">
                    <img class="object-fit-cover h-100 w-100" src="<?= $detailsCoverImageSrc ?>"
                        alt="<?= $detailsCoverImageAlt ?>">
                </div>

                <?php if (isset($detailsAvatarImageSrc) && $detailsAvatarImageSrc != null): ?>
                    <div class="details-avatar-image mb-3 ms-3">
                        <img class="object-fit-cover h-100 w-100" src="<?= $detailsAvatarImageSrc ?>"
                            alt="<?= $detailsAvatarImageAlt; ?>">
                    </div>
                <?php elseif (isset($detailsAvatarIcon)): ?>
                    <div class="details-avatar-image mb-3 ms-3 d-flex justify-content-center align-items-center color-second-600"
                        style="background-color: var(--color-first-180);">
                        <?= $detailsAvatarIcon; ?>
                    </div>
                <?php endif ?>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <h3>
                                <?= $name; ?>
                            </h3>
                        </div>
                        <div class="d-flex flex-wrap column-gap-3 row-gap-3">
                            <?php if (isset($updateHref)): ?>
                                <a href="<?= $updateHref; ?>" class="btn primary-btn">Update</a>
                            <?php endif; ?>

                            <?php if (isset($deleteHref)): ?>
                                <a type="button" href="<?= $deleteHref; ?>" class="btn primary-btn"
                                    data-href="<?= $deleteHref; ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    Delete
                                </a>
                            <?php endif; ?>


                            <?php if (isset($buttons)): ?>
                                <?php foreach ($buttons as $value): ?>
                                    <?= $value; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Delete Modal -->
<?= $this->include('include/delete_modal'); ?>