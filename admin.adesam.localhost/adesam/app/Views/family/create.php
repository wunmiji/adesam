<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="pt-4 row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?php $validation = \Config\Services::validation(); ?>

                <form method="POST" action="<?= '/family/create'; ?>"
                    onSubmit="document.getElementById('submit').disabled=true;">
                    <?= csrf_field(); ?>

                    <div>
                        <div class="card-form-title">Basic</div>

                        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 mb-4">
                            <div class="col">
                                <input type="text" name="first_name" id="firstNameInput" class="form-control"
                                    value="<?= set_value('first_name'); ?>" placeholder="Enter First Name" />
                                <?php if ($validation->getError('first_name')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('first_name'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col">
                                <input type="text" name="middle_name" id="middleNameInput" class="form-control"
                                    value="<?= set_value('middle_name'); ?>" placeholder="Enter Middle Name" />
                                <?php if ($validation->getError('middle_name')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('middle_name'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col">
                                <input type="text" name="last_name" id="lastNameInput" class="form-control"
                                    value="<?= set_value('last_name'); ?>" placeholder="Enter Last Name" />
                                <?php if ($validation->getError('last_name')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('last_name'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row row-cols-lg-2 row-cols-1 mb-4">
                            <div class="col">
                                <div class="d-flex justify-content-between form-control-div">
                                    <div>
                                        <label class="form-label mb-0">Gender</label>
                                    </div>
                                    <div class="d-flex column-gap-4">
                                        <?php $index = 0; ?>
                                        <?php foreach ($genderEnum as $key => $value): ?>
                                            <?php $index++; ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    value="<?= $key; ?>" id="flexRadioDefault<?= $index; ?>" <?= ($key == 'F') ? 'checked' : ''; ?>>
                                                <label class="form-check-label"
                                                    for="flexRadioDefault<?= $index; ?>"><?= $value; ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <input type="text" name="dob" id="dobInput" placeholder="Select Date of birth"
                                    class="form-control" data-input>
                                <?php if ($validation->getError('dob')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('dob'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <input type="text" name="mobile" id="mobileInput" class="form-control"
                                    value="<?= set_value('mobile'); ?>" placeholder="Enter Mobile" />
                                <?php if ($validation->getError('mobile')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('mobile'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 col-12">
                                <input type="text" name="telephone" id="telephoneInput" class="form-control"
                                    value="<?= set_value('telephone'); ?>" placeholder="Enter Telephone" />
                                <?php if ($validation->getError('telephone')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('telephone'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8 col-12">
                                <input type="email" name="email" class="form-control" id="emailInput"
                                    value="<?= set_value('email'); ?>" placeholder="Enter Email">
                                <?php if ($validation->getError('email')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('email'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-4 col-12">
                                <input type="text" name="role" id="roleInput" class="form-control"
                                    value="<?= set_value('role'); ?>" placeholder="Enter Role" />
                                <?php if ($validation->getError('role')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('role'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <textarea name="description" id="descriptionTextarea" class="form-control"
                                placeholder="Enter Description" rows="3"><?= set_value('description'); ?></textarea>
                            <?php if ($validation->getError('description')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('description'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                    </div>

                    <!-- Submit button -->
                    <button type="submit" name="submit" id="submit" class="btn primary-btn">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>



<?= $this->endSection(); ?>