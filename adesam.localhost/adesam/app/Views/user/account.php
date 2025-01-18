<?= $this->extend('layouts/default_user'); ?>


<!-- sections -->
<?= $this->section('content_user'); ?>




<section>
	<?php $validation = \Config\Services::validation(); ?>
	<div class="mb-4">
		<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Account Details']); ?>
	</div>
	<?= view_cell('\Cells\AlertCell::alertPost'); ?>

	<form method="POST" id="submitAccount" action="/user?tab=account" enctype="multipart/form-data"
		onSubmit="document.getElementById('submitAccount').disabled=true;">

		<div class="d-flex justify-content-center mb-5">
			<div class="">
				<div class="position-relative">
					<div class="p-1 card-border" style="border-width: 1px;">
						<img id="image-preview" class="object-fit-cover"
							src="<?= $dataImage->fileSrc ?? '/assets/images/avatar_user.png' ?>" width="100px"
							height="100px">
					</div>
					<div class="position-absolute top-100 start-100 translate-middle">
						<input type="file" id="user-image-input" name="file" hidden />
						<label class="btn" for="user-image-input">
							<i class='bx bxs-camera bx-sm'></i>
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row row-cols-lg-2 row-cols-1 mb-4">
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
				<input type="text" name="last_name" id="lastNameInput" class="form-control"
					value="<?= esc($data->lastName); ?>" placeholder="Last Name" />
				<?php if ($validation->getError('last_name')): ?>
					<span class="text-danger text-sm">
						<?= $error = $validation->getError('last_name'); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>

		<div class="row mb-4">
			<div class="col-md-7 col-12">
				<input type="email" class="form-control" id="emailInput" value="<?= esc($data->email); ?>"
					placeholder="Enter Email" name="email">
				<?php if ($validation->getError('email')): ?>
					<span class="text-danger text-sm">
						<?= $error = $validation->getError('email'); ?>
					</span>
				<?php endif; ?>
			</div>

			<div class="col-md-5 col-12">
				<input type="tel" name="mobile" id="mobileInput" class="form-control" value="<?= esc($data->mobile); ?>"
					placeholder="Enter Number" />
				<?php if ($validation->getError('mobile')): ?>
					<span class="text-danger text-sm">
						<?= $error = $validation->getError('mobile'); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>


		<div class="mb-4">
			<textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5"
				placeholder="Enter Description"><?= esc($data->description); ?></textarea>
			<?php if ($validation->getError('description')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('description'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="d-flex justify-content-center">
			<button type="submit" name="submit" class="btn primary-btn">Save Account Changes</button>
		</div>

	</form>
</section>



<?= $this->endSection(); ?>