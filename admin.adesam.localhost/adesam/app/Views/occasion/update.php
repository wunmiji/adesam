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

				<form method="POST" action="<?= '/occasions/' . $data->cipherId . '/update'; ?>"
					onSubmit="document.getElementById('submit').disabled=true;" class="project-form">

					<div>
						<div class="card-form-title">Basic</div>

						<div class="row row-cols-lg-2 row-cols-1 mb-4">
							<div class="col-lg-8 col-12">
								<input type="text" name="title" id="titleInput" value="<?= esc($data->title); ?>"
									class="form-control" placeholder="Enter Title" />
								<?php if ($validation->getError('title')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('title'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col-lg-4 col-12 d-flex flex-column row-gap-2">
								<div>
									<select class="form-select" id="statusDiv" name="status"
										aria-label="Default select example">
										<option selected disabled>Status</option>
										<?php foreach ($occasionEnum as $key => $value): ?>
											<option <?= ($key == $data->status) ? 'selected' : ''; ?> value='<?= $key; ?>'>
												<?= $value; ?>
											</option>
										<?php endforeach; ?>
									</select>
									<?php if ($validation->getError('status')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('status'); ?>
										</span>
									<?php endif; ?>
								</div>

								<div class="d-none" id="publishedDateDiv">
									<input type="text" name="publishedDate" id="publishedDateInput"
										placeholder="Select Published Date" class="form-control" data-input
										value="<?= esc($data->publishedDate) ?? null; ?>">
									<?php if ($validation->getError('publishedDate')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('publishedDate'); ?>
										</span>
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="mb-4">
							<textarea type="text" name="summary" id="summaryTextarea" class="form-control"
								placeholder="Enter Summary" rows="3"><?= esc($data->summary); ?></textarea>
							<?php if ($validation->getError('summary')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('summary'); ?>
								</span>
							<?php endif; ?>
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
							<div id="editor" class="form-control"></div>
							<input type="hidden" id="textHiddenInput" name="text" value="<?= esc($dataText->text); ?>">
							<?php if ($validation->getError('text')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('text'); ?>
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
									<?php $match = $dataTags; ?>
									<?php foreach ($tags as $key => $value): ?>
										<?php $tagIndex++; ?>
										<div class="col">
											<?php $id = in_array($value->id, $match) ? array_search($value->id, $match) : null; ?>
											<?php $jsonLabelValue = json_encode(["id" => $id, "tagId" => $value->id]); ?>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="tags[]"
													<?= in_array($value->id, $match) ? 'checked' : ''; ?>
													value='<?= $jsonLabelValue; ?>' id="labelRadioDefault<?= $tagIndex; ?>">
												<label class="form-check-label"
													for="labelRadioDefault<?= $tagIndex; ?>"><?= $value->name; ?></label>
											</div>
										</div>
									<?php endforeach ?>
								</div>


							</div>
						<?php endif; ?>
					</div>

					<div>
						<div class="card-form-title">Media</div>

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="dropszone"
									data-file-manager="<?= esc($dataFileManagerPrivateId); ?>"
									data-output="div-uploaded-files" data-multiple="true" data-bs-toggle="modal"
									data-bs-target="#filesModal">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="filesText"></p>
									<input type="hidden" id="filesHidden" value="<?= esc($dataMedias); ?>">
								</div>
								<div id="div-uploaded-files"></div>
							</div>
							<?php if ($validation->getError('files')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('files'); ?>
								</span>
							<?php endif; ?>
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