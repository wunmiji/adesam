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

				<form method="POST" action="/file-manager/<?= $dataPrivateId; ?>/create-folder"
					onSubmit="document.getElementById('submit').disabled=true;">
					<div>
						<div class="card-form-title">Basic</div>

						<div class="row g-4 mb-4">
							<div class="col-lg-6 col-12">
								<input type="text" name="name" id="nameInput" value="<?= set_value('name'); ?>"
									class="form-control" placeholder="Enter Name" />
								<?php if ($validation->getError('name')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('name'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col-lg-6 col-12">
								<div class="d-flex justify-content-between form-control-div">
									<div>
										<label class="form-label mb-0">Type</label>
									</div>
									<div class="d-flex column-gap-5">
										<?php $index = 0; ?>
										<?php foreach ($fileTypeEnum as $key => $value): ?>
											<?php $index++; ?>
											<div class="form-check">
												<input class="form-check-input" type="radio" name="type"
													value="<?= $key; ?>" id="flexRadioDefault<?= $index; ?>"
													<?= ($key == 'PUBLIC') ? 'checked' : ''; ?>>
												<label class="form-check-label"
													for="flexRadioDefault<?= $index; ?>"><?= $value; ?></label>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>

						</div>


						<div class="mb-4">
							<textarea type="text" name="description" id="descriptionInput" class="form-control"
								placeholder="Enter Description" rows="5"><?= set_value('description'); ?></textarea>
							<?php if ($validation->getError('description')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('description'); ?>
								</span>
							<?php endif; ?>
						</div>



					</div>

					<!-- Submit button -->
					<button type="submit" id="submit" name="submit" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>




<?= $this->endSection(); ?>