<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<div class="pt-5"></div>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8 col-sm-10 col-10">
            <div class="card card-border">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-center mb-2">
                        <?= view_cell('\Cells\MainCell::divTitle', ['title' => $title]); ?>
                    </div>

                    <?php $validation = \Config\Services::validation(); ?>
                    <?= view_cell('\App\Cells\AlertCell::alertPost'); ?>


                    <form method="POST" action="<?= base_url('/register'); ?>"
                        onSubmit="document.getElementById('submit').disabled=true;">
                        <?= csrf_field(); ?>

                        <div class="col mb-4">
                            <input type="text" name="first_name" id="firstNameInput" class="form-control"
                                value="<?= set_value('first_name'); ?>" placeholder="First Name" />
                            <?php if ($validation->getError('first_name')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('first_name'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="col mb-4">
                            <input type="text" name="last_name" id="lastNameInput" class="form-control"
                                value="<?= set_value('last_name'); ?>" placeholder="Last Name" />
                            <?php if ($validation->getError('last_name')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('last_name'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <input type="email" class="form-control" name="email" value="<?= set_value('email'); ?>"
                                placeholder="Email">
                            <?php if ($validation->getError('email')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('email'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

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
                            <input type="password" name="confrim_new_password" class="form-control"
                                id="confirmNewPasswordInput" placeholder="Confirm New Password">
                            <?php if ($validation->getError('confrim_new_password')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('confrim_new_password'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <button class="btn fs-5 primary-btn w-100" type="submit" id="submit"
                            name="submit">Register</button>

                    </form>

                    <div class="d-flex flex-column align-items-center mt-2">
                        <a class="small" href="/login">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>