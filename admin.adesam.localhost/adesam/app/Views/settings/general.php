<?= $this->extend('layouts/default_settings'); ?>

<?= $this->section('settings_content'); ?>

<div>
	<?php $validation = \Config\Services::validation(); ?>
	<form method="POST" action="/settings?tab=general" onSubmit="document.getElementById('submit').disabled=true;">
		<?= csrf_field(); ?>

		<div class="mb-4">
			<p>The default timezone is Nigeria (+01:00)</p>
			<select class="form-select" id="timezoneSelect" name="timezone" aria-label="Default select example">
				<option selected disabled>Select Timezones</option>
				<?php foreach ($timezones as $key => $timezone): ?>
					<option value='<?= $key; ?>' <?= ($data->timezone->value == $key) ? 'selected' : ''; ?>>
						<?= $timezone; ?>
					</option>
				<?php endforeach; ?>
			</select>
			<?php if ($validation->getError('timezone')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('timezone'); ?>
				</span>
			<?php endif; ?>
		</div>

		<!-- Submit button -->
		<button type="submit" name="submit" id="submit" class="btn primary-btn">Update</button>
	</form>
</div>


<?= $this->endSection(); ?>