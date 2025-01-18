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


                    <form method="POST" action="<?= '/login'; ?>"
                        onSubmit="document.getElementById('submit').disabled=true;">
                        <?= csrf_field(); ?>

                        <div class="mb-4">
                            <input type="email" class="form-control" name="email" value="<?= set_value('email'); ?>"
                                placeholder="Email">
                            <?php if ($validation->getError('email')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('email'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div>
                            <input type="password" class="form-control" name="password"
                                value="<?= set_value('password'); ?>" placeholder="Password">
                            <?php if ($validation->getError('password')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('password'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember_me" value="true"
                                        id="labelRadioDefault">
                                    <label class="form-check-label" for="labelRadioDefault">Remember Me</label>
                                </div>
                                <a class="small" href="/forget-password">Forget Password?</a>
                            </div>
                        </div>

                        <input type="hidden" name="items" id="items">
                        <input type="hidden" name="shipping-type" id="shipping-type">
                        <input type="hidden" name="payment-method" id="payment-method">

                        <button class="btn fs-5 primary-btn w-100" type="submit" id="submit" name="submit">Sign
                            in</button>

                    </form>

                    <div class="d-flex flex-column align-items-center mt-2">
                        <a class="small" href="/register">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>