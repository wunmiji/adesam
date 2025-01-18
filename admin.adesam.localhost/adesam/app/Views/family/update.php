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

                <form method="POST" action="<?= '/family/' . $data->cipherId . '/update'; ?>"
                    onSubmit="document.getElementById('submit').disabled=true;">
                    <?= csrf_field(); ?>

                    <div>
                        <div class="card-form-title">Basic</div>

                        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 mb-4">
                            <div class="col">
                                <input type="text" name="first_name" id="firstNameInput" class="form-control"
                                    value="<?= esc($data->firstName); ?>" placeholder="First Name" />
                                <?php if ($validation->getError('first_name')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('first_name'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col">
                                <input type="text" name="middle_name" id="middleNameInput" class="form-control"
                                    value="<?= esc($data->middleName); ?>" placeholder="Middle Name" />
                                <?php if ($validation->getError('middle_name')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('middle_name'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>


                            <div class="col">
                                <input type="text" name="last_name" id="lastNameInput" class="form-control"
                                    value="<?= esc($data->lastName); ?>" placeholder="Last Name" />
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
                                                    value="<?= $key; ?>" id="flexRadioDefault<?= $index; ?>"
                                                    <?= ($key == $genderValue) ? 'checked' : ''; ?>>
                                                <label class="form-check-label"
                                                    for="flexRadioDefault<?= $index; ?>"><?= $value; ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <input type="text" name="dob" id="dobInput" placeholder="Select Date of birth"
                                    class="form-control" value="<?= esc($data->dob); ?>" data-input>
                                <?php if ($validation->getError('dob')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('dob'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-8 col-12">
                                <input type="email" name="email" class="form-control" id="emailInput"
                                    value="<?= esc($data->email); ?>" placeholder="Enter Email">
                                <?php if ($validation->getError('email')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('email'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-4 col-12">
                                <input type="text" name="role" id="roleInput" class="form-control"
                                    value="<?= esc($data->role); ?>" placeholder="Enter Role" />
                                <?php if ($validation->getError('role')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('role'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="single-file-upload">
                                <div class="drop-zone py-5 text-center" id="dropzone"
                                    data-file-manager="<?= esc($dataFileManagerPrivateId); ?>"
                                    data-output="div-uploaded-file" data-multiple="false" data-bs-toggle="modal"
                                    data-bs-target="#filesModal">
                                    <i class='bx bx-cloud-upload fs-1'></i>
                                    <p class="fs-6" id="fileText"></p>
                                    <?php if (isset($dataImage->fileSrc)): ?>
                                        <input type="hidden" id="fileHidden" value="<?= esc(json_encode($dataImage)); ?>">
                                    <?php endif; ?>
                                </div>
                                <div id="div-uploaded-file"></div>
                            </div>
                            <?php if ($validation->getError('file')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('file'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <input type="text" name="mobile" id="mobileInput" class="form-control"
                                    value="<?= esc($data->mobile); ?>" placeholder="Enter Mobile" />
                                <?php if ($validation->getError('mobile')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('mobile'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 col-12">
                                <input type="text" name="telephone" id="telephoneInput" class="form-control"
                                    value="<?= esc($data->telephone); ?>" placeholder="Enter Telephone" />
                                <?php if ($validation->getError('telephone')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('telephone'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <textarea name="description" id="descriptionTextarea" class="form-control"
                                placeholder="Enter Description" rows="3"><?= esc($data->description); ?></textarea>
                            <?php if ($validation->getError('description')): ?>
                                <span class="text-danger text-sm">
                                    <?= $error = $validation->getError('description'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <div class="card-form-title">Social Media</div>

                        <div class="row row-cols-md-2 row-cols-1 row-gap-4 mb-4">
                            <div class="col">
                                <input type="text" name="facebook" id="facebookInput" class="form-control"
                                    value="<?= esc($dataSocialMedia->facebook ?? ''); ?>" placeholder="Facebook" />
                                <?php if ($validation->getError('facebook')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('facebook'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col">
                                <input type="text" name="instagram" id="instagramInput" class="form-control"
                                    value="<?= esc($dataSocialMedia->instagram ?? ''); ?>" placeholder="Instagram" />
                                <?php if ($validation->getError('instagram')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('instagram'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col">
                                <input type="text" name="linkedIn" id="linkedInInput" class="form-control"
                                    value="<?= esc($dataSocialMedia->linkedIn ?? ''); ?>" placeholder="LinkedIn" />
                                <?php if ($validation->getError('linkedIn')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('linkedIn'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col">
                                <input type="text" name="twitter" id="twitterInput" class="form-control"
                                    value="<?= esc($dataSocialMedia->twitter ?? ''); ?>" placeholder="Twitter" />
                                <?php if ($validation->getError('twitter')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('twitter'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="col">
                                <input type="text" name="youtube" id="youtubeInput" class="form-control"
                                    value="<?= esc($dataSocialMedia->youtube ?? ''); ?>" placeholder="Youtube" />
                                <?php if ($validation->getError('youtube')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('youtube'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="calendarId" value="<?= esc($calendarCipherId); ?>" />

                    <!-- Submit button -->
                    <button type="submit" name="submit" id="submit" class="btn primary-btn">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>



<?= $this->endSection(); ?>