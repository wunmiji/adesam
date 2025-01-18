<?= $this->extend('layouts/default_settings'); ?>

<?= $this->section('settings_content'); ?>

<div>

	<?php $validation = \Config\Services::validation(); ?>
	<form method="POST" action="/settings?tab=contact" onSubmit="document.getElementById('submit').disabled=true;">
		<?= csrf_field(); ?>

		<p>The values are use in app contact page.</p>

		<div class="mb-4">
			<input type="email" name="email" class="form-control" id="emailInput"
				value="<?= esc($data->email->value ?? ''); ?>" placeholder="Enter Email">
			<?php if ($validation->getError('email')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('email'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="mb-4">
			<input type="tel" name="mobile" id="mobileInput" class="form-control"
				value="<?= esc($data->mobile->value ?? ''); ?>" placeholder="Enter Mobile" />
			<?php if ($validation->getError('mobile')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('mobile'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="mb-4">
			<input type="text" name="facebook" id="facebookInput" class="form-control"
				value="<?= esc($data->facebook->value ?? ''); ?>" placeholder="Facebook" />
			<?php if ($validation->getError('facebook')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('facebook'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="mb-4">
			<input type="text" name="instagram" id="instagramInput" class="form-control"
				value="<?= esc($data->instagram->value ?? ''); ?>" placeholder="Instagram" />
			<?php if ($validation->getError('instagram')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('instagram'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="mb-4">
			<input type="text" name="linkedIn" id="linkedInInput" class="form-control"
				value="<?= esc($data->linkedIn->value ?? ''); ?>" placeholder="LinkedIn" />
			<?php if ($validation->getError('linkedIn')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('linkedIn'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="mb-4">
			<input type="text" name="twitter" id="twitterInput" class="form-control"
				value="<?= esc($data->twitter->value ?? ''); ?>" placeholder="Twitter" />
			<?php if ($validation->getError('twitter')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('twitter'); ?>
				</span>
			<?php endif; ?>
		</div>

		<div class="mb-4">
			<input type="text" name="youtube" id="youtubeInput" class="form-control"
				value="<?= esc($data->youtube->value ?? ''); ?>" placeholder="Youtube" />
			<?php if ($validation->getError('youtube')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('youtube'); ?>
				</span>
			<?php endif; ?>
		</div>



		<!-- Submit button -->
		<button type="submit" name="submit" id="submit" class="btn primary-btn">Update</button>
	</form>
</div>


<?= $this->endSection(); ?>