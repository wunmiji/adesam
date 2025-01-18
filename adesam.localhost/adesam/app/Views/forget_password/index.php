<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<div class="pt-5"></div>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<?php if (!empty(session()->getFlashData('success'))): ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-10 col-10">
                <div class="d-flex justify-content-center mb-2">
                    <?= view_cell('\Cells\MainCell::divTitle', ['title' => $title]); ?>
                </div>

                <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
            </div>
        </div>
    </div>
<?php elseif (!empty(session()->getFlashData('fail'))): ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-10 col-10">
                <div class="d-flex justify-content-center mb-2">
                    <?= view_cell('\Cells\MainCell::divTitle', ['title' => $title]); ?>
                </div>

                <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $validation = \Config\Services::validation(); ?>

<?php if (empty(session()->getFlashData('success'))): ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-10 col-10">
                <div class="card card-border">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-center mb-2">
                            <?= view_cell('\Cells\MainCell::divTitle', ['title' => $title]); ?>
                        </div>

                        <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

                        <form method="POST" action="<?= '/forget-password'; ?>"
                            onSubmit="document.getElementById('submit').disabled=true;">
                            <?= csrf_field(); ?>

                            <div class="mb-4">
                                <input type="email" class="form-control p-3 quicksand-semibold" name="email"
                                    value="<?= set_value('email'); ?>" placeholder="Email">
                                <?php if ($validation->getError('email')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('email'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <button class="btn fs-5 primary-btn w-100" type="submit" id="submit" name="submit">Send Reset
                                Link</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?= $this->endSection(); ?>