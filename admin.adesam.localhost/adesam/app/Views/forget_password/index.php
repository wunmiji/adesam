<?= $this->extend('layouts/login'); ?>




<?= $this->section('title'); ?>
<h6><?= $title; ?></h6>
<?= $this->endSection(); ?>






<?= $this->section('content'); ?>

<?php if (!empty(session()->getFlashData('success'))): ?>
    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
<?php elseif (!empty(session()->getFlashData('fail'))): ?>
    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
<?php endif; ?>
<?php $validation = \Config\Services::validation(); ?>



<?php if (empty(session()->getFlashData('success'))): ?>
    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>
    <form method="POST" action="/forget-password" onSubmit="document.getElementById('submit').disabled=true;">
        <?= csrf_field(); ?>

        <div class="mb-4">
            <input type="email" class="form-control" name="email" value="<?= set_value('email'); ?>" placeholder="Email">
            <?php if ($validation->getError('email')): ?>
                <span class="text-danger text-sm">
                    <?= $error = $validation->getError('email'); ?>
                </span>
            <?php endif; ?>
        </div>

        <button class="btn primary-btn w-100" type="submit" id="submit" name="submit">Send
            Reset Link</button>

    </form>

    <div class="text-center mt-2">
        <a class="small" href="/">Login</a>
    </div>
<?php endif; ?>

<?= $this->endSection(); ?>