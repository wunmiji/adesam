<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5">
		<?= $title; ?>
	</div>
</div>

<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?php $validation = \Config\Services::validation(); ?>

				<form method="POST" action="<?= '/products/' . $data->cipherId . '/update'; ?>"
					onSubmit="document.getElementById('submit').disabled=true;">

					<div>
						<div class="card-form-title">Basic</div>

						<div class="row row-cols-lg-2 row-cols-1 mb-4">
							<div class="col-lg-8 col-12">
								<input type="text" name="name" id="nameInput" value="<?= esc($data->name); ?>"
									class="form-control" placeholder="Enter Name" />
								<?php if ($validation->getError('name')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('name'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col-lg-4 col-12">
								<select class="form-select" id="visibilityStatusSelect" name="visibility-status"
									aria-label="Default select example">
									<option selected disabled>Select Visibility Status</option>
									<?php foreach ($visibilityStatusEnum as $key => $value): ?>
										<option value='<?= $key; ?>' <?= ($key == $data->visibilityStatus) ? 'selected' : ''; ?>>
											<?= $value; ?>
										</option>
									<?php endforeach; ?>
								</select>
								<?php if ($validation->getError('visibility-status')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('visibility-status'); ?>
									</span>
								<?php endif; ?>
							</div>

						</div>

						<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 mb-4">
							<div class="col">
								<input type="text" name="sku" id="skuInput" class="form-control"
									value="<?= esc($data->sku); ?>" placeholder="Enter SKU" />
								<?php if ($validation->getError('sku')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('sku'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col">
								<input type="text" name="quantity" id="quantityInput" class="form-control"
									onkeypress="return quantityKey(event)" maxlength="7"
									value="<?= esc($data->quantity); ?>" placeholder="Enter Quantity" />
								<?php if ($validation->getError('quantity')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('quantity'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col">
								<select class="form-select" id="categorySelect" name="category"
									aria-label="Default select example">
									<option selected disabled>Select Category</option>
									<?php foreach ($categories as $key => $value): ?>
										<option value='<?= \App\Libraries\SecurityLibrary::encryptUrlId($value->id); ?>'
											<?= ($value->id == $dataCategory->categoryId) ? 'selected' : ''; ?>>
											<?= $value->name; ?>
										</option>
									<?php endforeach; ?>
								</select>
								<?php if ($validation->getError('category')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('category'); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>

						<div class="mb-4">
							<textarea type="text" name="description" id="descriptionTextarea" class="form-control"
								placeholder="Enter Short Description"
								rows="3"><?= esc($data->description); ?></textarea>
							<?php if ($validation->getError('description')): ?>
								<span class="text-danger text-sm">
									<?= $error = $validation->getError('description'); ?>
								</span>
							<?php endif; ?>
						</div>

						<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 mb-4">
							<div class="col">
								<div class="input-group flex-nowrap">
									<span class="input-group-text" id="addon-wrapping"><?= $currencySymbol ?></span>
									<input type="text" name="cost_price" id="costPriceInput" class="form-control"
										oninput="costPriceKey(this);" value="<?= esc($data->costPrice); ?>"
										placeholder="Enter Cost Price" aria-label="cost_price"
										aria-describedby="addon-wrapping" />
								</div>
								<?php if ($validation->getError('cost_price')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('cost_price'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col">
								<div class="input-group flex-nowrap">
									<span class="input-group-text" id="addon-wrapping"><?= $currencySymbol ?></span>
									<input type="text" name="selling_price" id="sellingPriceInput" class="form-control"
										oninput="sellingPriceKey(this);" value="<?= esc($data->sellingPrice); ?>"
										placeholder="Enter Selling Price" aria-label="selling_price"
										aria-describedby="addon-wrapping" />
								</div>
								<?php if ($validation->getError('selling_price')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('selling_price'); ?>
									</span>
								<?php endif; ?>
							</div>

							<div class="col">
								<select class="form-select" id="discountSelect" name="discount"
									aria-label="Default select example">
									<option selected disabled>Select Discount</option>
									<?php foreach ($discounts as $key => $value): ?>
										<option value='<?= \App\Libraries\SecurityLibrary::encryptUrlId($value->id); ?>'
											<?= (is_null($dataDiscount) ? '' : (($value->id == $dataDiscount->discountId) ? 'selected' : '')) ?>>
											<?= $value->stringDiscount; ?>
										</option>
									<?php endforeach; ?>
								</select>
								<?php if ($validation->getError('discount')): ?>
									<span class="text-danger text-sm">
										<?= $error = $validation->getError('discount'); ?>
									</span>
								<?php endif; ?>
							</div>
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
						<div class="card-form-title">Images</div>

						<div class="mb-4">
							<div class="single-file-upload">
								<div class="drop-zone py-5 text-center" id="dropszone"
									data-file-manager="<?= esc($dataFileManagerPrivateId); ?>"
									data-output="div-uploaded-files" data-multiple="true" data-bs-toggle="modal"
									data-bs-target="#filesModal">
									<i class='bx bx-cloud-upload fs-1'></i>
									<p class="fs-6" id="filesText"></p>
									<input type="hidden" id="filesHidden" value="<?= esc($dataImages); ?>">
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
											<?php $jsonLabelValue = json_encode(["id" => \App\Libraries\SecurityLibrary::encryptUrlId($id), "tagId" => \App\Libraries\SecurityLibrary::encryptUrlId($value->id)]); ?>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="tags[]"
													<?= in_array($value->id, $match) ? 'checked' : ''; ?>
													value='<?= $jsonLabelValue; ?>' id="tagRadioDefault<?= $tagIndex; ?>">
												<label class="form-check-label"
													for="tagRadioDefault<?= $tagIndex; ?>"><?= $value->name; ?></label>
											</div>
										</div>
									<?php endforeach ?>
								</div>


							</div>
						<?php endif; ?>
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
					<button type="submit" name="submit" id="submit" onclick="saveContent();"
						class="btn primary-btn">Update</button>
				</form>
			</div>
		</div>
	</div>
</div>



<!-- files_modal -->
<?= $this->include('include/files_modal'); ?>


<?= $this->endSection(); ?>