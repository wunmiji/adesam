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
                <p><a class="fs-5 fw-bold" href="/login">Click here</a> to login</p>
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


                        <form method="POST" action="<?= base_url('/reset-password'); ?>"
                            onSubmit="document.getElementById('submit').disabled=true;">
                            <?= csrf_field(); ?>


                            <div class="mb-4">
                                <input type="password" name="new_password" class="form-control quicksand-semibold"
                                    id="newPasswordInput" placeholder="New Password">
                                <?php if ($validation->getError('new_password')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('new_password'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <input type="password" name="confrim_new_password" class="form-control quicksand-semibold"
                                    id="confirmNewPasswordInput" placeholder="Confirm New Password">
                                <?php if ($validation->getError('confrim_new_password')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('confrim_new_password'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex flex-column align-items-center row-gap-2">
                                <input type="hidden" name="tokenHidden" value="<?= esc($token); ?>">
                                <button class="btn fs-5 primary-btn w-100" type="submit" id="submit" name="submit">Reset
                                    Password</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?= $this->endSection(); ?>