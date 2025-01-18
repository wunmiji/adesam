<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a class="btn primary-btn" data-bs-toggle="modal" data-bs-target="#discountModal">New Discount</a>'
	]
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Products</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($datas)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = 0; ?>
								<?php foreach ($datas as $key => $data): ?>
									<?php $dataProducts = $data->products; ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<?= $data->stringDiscount; ?>
										</td>
										<td class="text-wrap">
											<div class="d-flex flex-wrap column-gap-3 row-gap-2">
												<?php foreach ($dataProducts as $dataProduct): ?>
													<div class="d-flex">
														<div class="flex-shrink-0">
															<img width="27px" height="27px" class="object-fit-cover"
																src="<?= $dataProduct->fileSrc ?? '/assets/images/avatar-product.png'; ?>"
																alt="<?= $dataProduct->fileName ?? 'Image not set avatar used'; ?>">
														</div>
														<div class="flex-grow-1 ms-1">
															<a href="<?= $dataProduct->productCipherId; ?>"
																class="mb-0"><?= $dataProduct->name; ?></a>
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										</td>
										<td class="text-nowrap" style="font-size: 1.2rem;">
											<div class="d-flex column-gap-2">
												<a data-name="<?= esc($data->name); ?>" data-value="<?= esc($data->value); ?>"
													data-type="<?= esc($data->type); ?>"
													data-count="<?= esc(count($dataProducts)); ?>"
													data-created="<?= esc($data->createdDateTime); ?>" data-bs-toggle="modal"
													data-bs-target="#discountInfoModal">
													<i class='bx bx-info-circle'></i>
												</a>

												<?php $deleteHref = '/products/discounts/' . $data->cipherId . '/delete'; ?>
												<a href="<?= $deleteHref; ?>" data-href="<?= $deleteHref; ?>"
													data-bs-toggle="modal" data-bs-target="#deleteModal">
													<i class='bx bx-trash-alt'></i>
												</a>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>





<!-- New Discount modal -->
<div class="modal fade" id="discountModal" tabindex="-1" aria-discountledby="discountModalTag" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">New Discount</div>
			</div>
			<div class="modal-body" id="discountModalBodyDiv">
				<form method="POST" id="discountModalForm" action="<?= '/products/discounts/create'; ?>"
					onSubmit="document.getElementById('submitDiscount').disabled=true;">
					<div class="mb-4">
						<input type="text" name="name" id="nameModalInput" class="form-control"
							placeholder="Enter Name" />
					</div>

					<div class="row row-cols-md-2 row-cols-1 mb-4">
						<div class="col">
							<select class="form-select" name="type" aria-discount="Default select example">
								<option selected disabled>Type</option>

								<?php foreach ($discountEnum as $key => $data): ?>
									<option value='<?= $key; ?>'>
										<?= $data; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col">
							<input type="text" name="value" id="dataInput" class="form-control"
								placeholder="Enter Value" />
						</div>
					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" id="submitDiscount" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Info modal -->
<div class="modal fade" id="discountInfoModal" tabindex="-1" aria-discountledby="discountInfoModalInfo" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">Info</div>
			</div>
			<div class="modal-body" id="discountInfoModalBodyDiv">
			</div>
		</div>
	</div>
</div>

<!-- delete_modal -->
<?= $this->include('include/delete_modal'); ?>


<?= $this->endSection(); ?>