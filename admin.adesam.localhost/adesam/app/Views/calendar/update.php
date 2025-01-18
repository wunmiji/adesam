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

				<form method="POST" action="<?= '/calendar/' . $dataDate . '/' . $data->cipherId . '/update'; ?>"
					onSubmit="document.getElementById('submit').disabled=true;">

					<div>
						<div class="card-form-title">Basic</div>

						<div class="row mb-4">
							<div class="col-md-8 col-sm-6 col-12">
								<input type="text" name="title" class="form-control" id="titleInput"
									value="<?= esc($data->title); ?>" placeholder="Enter Title">
								<?php if ($validation->getError('title')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('title'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col-md-4 col-sm-6 col-12">
								<select class="form-select" id="typeSelect" name="type"
									aria-label="Default select example">
									<option selected disabled>Select Type</option>
									<?php foreach ($calendarEnum as $key => $value): ?>
										<option value='<?= $key; ?>' <?= ($key == $data->type) ? 'selected' : ''; ?>>
											<?= $value; ?>
										</option>
									<?php endforeach; ?>
								</select>
								<?php if ($validation->getError('type')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('type'); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>


						<div class="row row-cols-lg-3 row-cols-1 mb-4">
							<div class="col">
								<select class="form-select" id="recurringTypeSelect" name="recurringType"
									aria-label="Default select example">
									<option selected disabled>Select Recurring Type</option>
									<?php foreach ($CalendarRecurringEnum as $key => $value): ?>
										<option value='<?= $key; ?>' <?= ($key == $data->recurringType) ? 'selected' : ''; ?>>
											<?= $value; ?>
										</option>
									<?php endforeach; ?>
								</select>
								<?php if ($validation->getError('recurringType')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('recurringType'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col">
								<input type="text" name="startDateTime" id="startDateTimeInput"
									placeholder="Select Start Date Time" value="<?= esc($data->start); ?>"
									class="form-control" data-input>
								<?php if ($validation->getError('startDateTime')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('startDateTime'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col">
								<input type="text" name="endDateTime" id="endDateTimeInput"
									placeholder="Select End Date Time" value="<?= esc($data->end); ?>"
									class="form-control" data-input>
								<?php if ($validation->getError('endDateTime')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('endDateTime'); ?>
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

					<div id="div-additionalInformations-section">
						<div class="d-flex justify-content-between align-items-center form-title">
							<span class="card-form-title">Additional Information</span>
							<button class="btn px-0" id="plus-button"><i class='bx bx-plus bx-sm'></i></button>
							<input type="hidden" id="additionalInformationsHidden" name="additionalInformationsHidden"
								value="<?= esc($dataAdditionalInformations); ?>">
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