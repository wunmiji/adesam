<?= $this->extend('layouts/default_user'); ?>


<!-- sections -->
<?= $this->section('content_user'); ?>





<section>
	<?php $validation = \Config\Services::validation(); ?>

	<div class="mb-4">
		<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Password Change']); ?>
	</div>
	<?= view_cell('\Cells\AlertCell::alertPost'); ?>

	<form method="POST" id="submitPassword" action="/user?tab=password"
		onSubmit="document.getElementById('submitPassword').disabled=true;">

		<div class="mb-4">
			<input type="password" name="current_password" class="form-control" id="currentPasswordInput"
				placeholder="Current Password">
			<?php if ($validation->getError('current_password')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('current_password'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="row row-cols-lg-2 row-cols-1 mb-4">
			<div class="col">
				<input type="password" name="new_password" class="form-control" id="newPasswordInput"
					placeholder="New Password">
				<?php if ($validation->getError('new_password')): ?>
					<span class="text-danger text-sm">
						<?= $error = $validation->getError('new_password'); ?>
					</span>
				<?php endif; ?>
			</div>

			<div class="col">
				<input type="password" name="confrim_new_password" class="form-control" id="confirmNewPasswordInput"
					placeholder="Confirm New Password">
				<?php if ($validation->getError('confrim_new_password')): ?>
					<span class="text-danger text-sm">
						<?= $error = $validation->getError('confrim_new_password'); ?>
					</span>
				<?php endif; ?>
			</div>
		</div>

		<div class="d-flex justify-content-center">
			<button type="submit" name="submit" class="btn primary-btn">Save Password Changes</button>
		</div>

	</form>
</section>


<?= $this->endSection(); ?>