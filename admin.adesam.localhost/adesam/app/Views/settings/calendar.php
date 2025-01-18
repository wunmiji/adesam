<?= $this->extend('layouts/default_settings'); ?>

<?= $this->section('settings_content'); ?>

<div>
	<?php $validation = \Config\Services::validation(); ?>
	<form method="POST" action="/settings?tab=calendar" onSubmit="document.getElementById('submit').disabled=true;">
		<?= csrf_field(); ?>

		<div class="mb-4">
			<p>The default first day is Sunday</p>
			<select class="form-select" id="daySelect" name="day" aria-label="Default select example">
				<option selected disabled>Select Day</option>
				<?php foreach ($days as $key => $day): ?>
					<option value='<?= $key; ?>' <?= ($data->{'first-day'}->value == $key) ? 'selected' : ''; ?>>
						<?= $day; ?>
					</option>
				<?php endforeach; ?>
			</select>
			<?php if ($validation->getError('day')): ?>
				<span class="text-danger text-sm">
					<?= $error = $validation->getError('day'); ?>
				</span>
			<?php endif; ?>
		</div>

		<!-- Submit button -->
		<button type="submit" name="submit" id="submit" class="btn primary-btn">Update</button>
	</form>
</div>


<?= $this->endSection(); ?>