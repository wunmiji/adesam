<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

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

				<form method="POST" action="<?= '/contacts/create'; ?>"
					onSubmit="document.getElementById('submit').disabled=true;">

					<div>
						<div class="card-form-title">Basic</div>

						<div class="row row-cols-md-2 row-cols-1 mb-4">
							<div class="col">
								<div class="d-flex justify-content-between form-control-div">
									<div>
										<label class="form-label mb-0">Type</label>
									</div>
									<div class="d-flex column-gap-4">
										<?php $index = 0; ?>
										<?php foreach ($contactEnum as $key => $value): ?>
											<?php $index++; ?>
											<div class="form-check">
												<input class="form-check-input" type="radio" name="type"
													value="<?= $key; ?>" id="contactRadioDefault<?= $index; ?>"
													<?= ($key == \App\Enums\ContactType::PUBLIC ->name) ? 'checked' : ''; ?>>
												<label class="form-check-label"
													for="contactRadioDefault<?= $index; ?>"><?= $value; ?></label>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>

							<div class="col">
								<input type="text" name="nickname" class="form-control" id="nicknameInput"
									value="<?= set_value('nickname'); ?>" placeholder="Enter NickName">
								<?php if ($validation->getError('nickname')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('nickname'); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>


						<div class="row row-cols-md-2 row-cols-1 mb-4">
							<div class="col">
								<input type="text" name="first_name" id="firstNameInput" class="form-control"
									value="<?= set_value('first_name'); ?>" placeholder="First Name" />
								<?php if ($validation->getError('first_name')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('first_name'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col">
								<input type="text" name="last_name" id="lastNameInput" class="form-control"
									value="<?= set_value('last_name'); ?>" placeholder="Last Name" />
								<?php if ($validation->getError('last_name')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('last_name'); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>

						<div class="row mb-4">
							<div class="col-md-7 col-12">
								<input type="email" name="email" class="form-control" id="emailInput"
									value="<?= set_value('email'); ?>" placeholder="Enter Email">
								<?php if ($validation->getError('email')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('email'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col-md-5 col-12">
								<input type="tel" name="mobile" id="mobileInput" class="form-control"
									value="<?= set_value('mobile'); ?>" placeholder="Enter Mobile Number" />
								<?php if ($validation->getError('mobile')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('mobile'); ?>
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
											<div class="form-check mb-0">
												<input class="form-check-input" type="radio" name="gender"
													value="<?= $key; ?>" id="genderRadioDefault<?= $index; ?>"
													<?= ($key == \App\Enums\Gender::F->name) ? 'checked' : ''; ?>>
												<label class="form-check-label"
													for="genderRadioDefault<?= $index; ?>"><?= $value; ?></label>
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

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="dropzone"
									data-file-manager="<?= esc($dataFileManagerPrivateId); ?>"
									data-output="div-uploaded-file" data-multiple="false" data-bs-toggle="modal"
									data-bs-target="#filesModal">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="fileText"></p>
								</div>
								<div id="div-uploaded-file"></div>
							</div>
							<?php if ($validation->getError('file')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('file'); ?>
								</span>
							<?php endif; ?>
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

					<div>
						<?php if (!empty($tags)): ?>
							<div class="card-form-title">Tags</div>

							<div class="form-control-div mb-4">
								<div class="row row-cols-lg-4 row-cols-md-3 row-cols-1 g-4">

									<?php $tagIndex = 0; ?>
									<?php foreach ($tags as $key => $value): ?>
										<?php $tagIndex++; ?>
										<div class="col">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="tags[]"
													value="<?= $value->id; ?>" id="tagRadioDefault<?= $tagIndex; ?>">
												<label class="form-check-label"
													for="tagRadioDefault<?= $tagIndex; ?>"><?= $value->name; ?></label>
											</div>
										</div>
									<?php endforeach ?>
								</div>


							</div>
						<?php endif; ?>
					</div>

					<div>
						<div class="card-form-title">Address</div>

						<div class="mb-4">
							<input type="text" name="address" class="form-control" id="addressInput"
								value="<?= set_value('address'); ?>" placeholder="Enter Address">
							<?php if ($validation->getError('address')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('address'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="row">
							<div class="col-md-7 col-12 mb-4">
								<input type="text" name="postal_code" class="form-control" id="postalCodeInput"
									value="<?= set_value('postal_code'); ?>" placeholder="Enter Postal Code">
								<?php if ($validation->getError('postal_code')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('postal_code'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col-md-5 col-12 mb-4">
								<select class="form-select" name="countries" aria-label="Default select example">
									<option selected disabled>Countries</option>

									<?php foreach ($countries as $key => $value): ?>
										<option
											value='<?= json_encode(["name" => $value->name, "code" => $value->iso3]); ?>'>
											<?= $value->name; ?>
										</option>
									<?php endforeach; ?>
								</select>
								<?php if ($validation->getError('countries')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('countries'); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div id="div-additionalInformations-section">
						<div class="d-flex justify-content-between align-items-center form-title">
							<span class="card-form-title">Additional Information</span>
							<button class="btn px-0" id="plus-button"><i class='bx bx-plus bx-sm'></i></button>
							<input type="hidden" id="additionalInformationsHidden" name="additionalInformationsHidden">
						</div>

						<div id="div-additionalInformations"></div>

					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" id="submit" class="btn primary-btn"
						onclick="saveContent()">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>


<?= $this->endSection(); ?>