<?= $this->extend('layouts/login'); ?>

<?= $this->section('title'); ?>
<h6>Login</h6>
<?= $this->endSection(); ?>






<?= $this->section('content'); ?>
<?php $validation = \Config\Services::validation(); ?>
<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>


<form method="POST" action="<?= '/'; ?>" onSubmit="document.getElementById('submit').disabled=true;">
    <?= csrf_field(); ?>

    <div class="mb-4">
        <input type="email" class="form-control" name="email" value="<?= set_value('email'); ?>" placeholder="Email">
        <?php if ($validation->getError('email')): ?>
            <span class="text-danger text-sm">
                <?= $error = $validation->getError('email'); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <input type="password" class="form-control" name="password" value="<?= set_value('password'); ?>"
            placeholder="Password">
        <?php if ($validation->getError('password')): ?>
            <span class="text-danger text-sm">
                <?= $error = $validation->getError('password'); ?>
            </span>
        <?php endif; ?>
    </div>

    <button class="btn primary-btn w-100" type="submit" id="submit" name="submit">Sign in</button>

</form>

<div class="text-center mt-2">
    <a class="small" href="/forget-password">Forget Password?</a>
</div>

<?= $this->endSection(); ?>