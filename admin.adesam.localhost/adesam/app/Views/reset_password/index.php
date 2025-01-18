<?= $this->extend('layouts/login'); ?>




<?= $this->section('title'); ?>
<h6>Reset Password</h6>
<?= $this->endSection(); ?>




<?= $this->section('content'); ?>

<?php if (!empty(session()->getFlashData('success'))): ?>
    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
    <p><a class="fs-5 fw-bold" href="/">Click here</a> to login</p>
<?php elseif (!empty(session()->getFlashData('fail'))): ?>
    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
<?php endif; ?>
<?php $validation = \Config\Services::validation(); ?>




<?php if (empty(session()->getFlashData('success'))): ?>
    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
    <form method="POST" action="<?= '/reset-password'; ?>" onSubmit="document.getElementById('submit').disabled=true;">
        <?= csrf_field(); ?>


        <div class="mb-4">
            <input type="password" name="new_password" class="form-control" id="newPasswordInput"
                placeholder="New Password">
            <?php if ($validation->getError('new_password')): ?>
                <span class="text-danger text-sm">
                    <?= $error = $validation->getError('new_password'); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <input type="password" name="confrim_new_password" class="form-control" id="confirmNewPasswordInput"
                placeholder="Confirm New Password">
            <?php if ($validation->getError('confrim_new_password')): ?>
                <span class="text-danger text-sm">
                    <?= $error = $validation->getError('confrim_new_password'); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="d-flex flex-column align-items-center row-gap-2">
            <input type="hidden" name="tokenHidden" value="<?= esc($token); ?>">
            <button class="btn primary-btn w-100" type="submit" id="submit" name="submit">Reset
                Password</button>
        </div>

    </form>
<?php endif; ?>

<?= $this->endSection(); ?>