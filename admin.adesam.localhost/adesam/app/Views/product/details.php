<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<?php $dataCardHeader = [
	'detailsCoverImageSrc' => '/assets/images/background-image.jpg',
	'detailsCoverImageAlt' => 'Cover Image',
	'detailsAvatarImageSrc' => $dataImage->fileSrc ?? null,
	'detailsAvatarImageAlt' => $dataImage->fileName ?? null,
	'name' => $data->name,
	'updateHref' => '/products/' . $data->cipherId . '/update',
	'deleteHref' => '/products/' . $data->cipherId . '/delete',
	'buttons' => [],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-lg-5 col-md-6 col-12">
		<?php $basicRow = [
			'rows' => [
				'Name' => $data->name,
				'Stock Status' => view_cell('\App\Cells\UiCell::productStockbadge', ['status' => $data->stockStatus]),
				'Visibility Status' => view_cell('\App\Cells\UiCell::productVisibiltybadge', ['status' => $data->visibilityStatus]),
				'Description' => $data->description,
				'SKU' => $data->sku,
				'Unique' => '#' . $data->unique,
				'Discount' => $dataDiscount->stringDiscount ?? 'Not Available',
				'Cost Price' => $data->stringCostPrice,
				'Selling Price' => $data->stringSellingPrice,
				'Actual Selling Price' => $data->stringActualSellingPrice,
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 31, // Add 1rem for gap space
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-lg-7 col-md-6 col-12">
		<div class="row g-3">
			<div class="col-12">
				<div class="card" style="height: 23rem; min-height: 23rem;">
					<div class="card-header card-header-title">Images</div>
					<div class="card-body overflow-y-auto">
						<?php if (empty($dataImages)): ?>
							<small>No data yet</small>
						<?php else: ?>
							<div class="row g-3">
								<?php foreach ($dataImages as $key => $dataImage): ?>
									<div class="col-lg-3 col-md-4 col-6">
										<div class="card shadow-none h-100 w-100">
											<?php if (str_starts_with($dataImage->fileMimetype, 'image')): ?>
												<div class="w-100 h-100 position-relative">
													<img class="object-fit-cover" style="width: inherit; height: inherit;"
														role="button" data-bs-toggle="modal" data-bs-target="#viewModal"
														src="<?= $dataImage->fileSrc; ?>" alt="<?= $dataImage->fileName; ?>"
														data-src="<?= $dataImage->fileSrc; ?>"
														data-name="<?= $dataImage->fileName; ?>"
														data-mime="<?= $dataImage->fileMimetype; ?>">
												</div>

												<div class="card-body text-center px-0">
													<small class="card-text">
														<?= $dataImage->fileName; ?>
													</small>
												</div>
											<?php elseif (str_starts_with($dataImage->fileMimetype, 'video')): ?>
												<div class="w-100 h-100 position-relative">
													<video class="object-fit-cover"
														style="width: inherit; height: inherit;" role="button"
														data-bs-toggle="modal" data-bs-target="#viewModal"
														data-src="<?= $dataImage->fileSrc; ?>"
														data-name="<?= $dataImage->fileName; ?>"
														data-mime="<?= $dataImage->fileMimetype; ?>">
														<source src="<?= $dataImage->fileSrc; ?>"
															type="<?= $dataImage->fileMimetype; ?>">
														<?= $dataImage->fileName; ?>
													</video>
													<i class='bx bx-play-circle bx-lg position-absolute top-50 start-50 translate-middle white-color'
														style="pointer-products: none;"></i>
												</div>

												<div class="card-body text-center px-0">
													<small class="card-text">
														<?= $dataImage->fileName; ?>
													</small>
												</div>
											<?php elseif (str_starts_with($dataImage->fileMimetype, 'audio')): ?>
												<audio class="card-img-top" data-bs-toggle="modal"
													data-bs-target="#viewModal" data-src="<?= $dataImage->fileSrc; ?>"
													data-name="<?= $dataImage->fileName; ?>"
													data-mime="<?= $dataImage->fileMimetype; ?>" controls>
													<source src="<?= $dataImage->fileSrc; ?>"
														type="<?= $dataImage->fileMimetype; ?>">
													<?= $dataImage->fileName; ?>
												</audio>
												<div class="card-body text-center px-0">
													<small class="card-text">
														<?= $dataImage->fileName; ?>
													</small>
												</div>
											<?php else: ?>
												<img class="image-fluid" src="/assets/images/file_mime_type_unknown.png"
													alt="<?= $dataImage->fileName; ?>">
												<div class="card-body px-0">
													<small class="card-text">
														<?= $dataImage->fileName; ?>
													</small>
												</div>
											<?php endif ?>

										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif ?>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card" style="height: 7rem; min-height: 7rem;">
					<div class="card-header card-header-title">Tags</div>
					<div class="card-body overflow-y-auto">
						<?php if (empty($dataTags)): ?>
							<small>No data yet</small>
						<?php else: ?>
							<div class="d-flex gap-3">
								<?php foreach ($dataTags as $key => $dataTag): ?>
									<?= view_cell('\App\Cells\UiCell::tagBadge', ['name' => $dataTag->tagName]) ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- data_additional_imformations -->
<?= view_cell(
	'\App\Cells\DetailsCell::additionalInformations',
	['dataAdditionalInformations' => $dataAdditionalInformations]
); ?>



<!-- data_text -->
<?= $this->include('include/data_text'); ?>

<!-- order_product -->
<div class="row my-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header card-header-title">Orders</div>
			<div class="card-body">
				<table id="table" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Order</th>
							<th scope="col">Date</th>
							<th scope="col">Quantity</th>
							<th class="text-end" scope="col">Price</th>
							<th class="text-end" scope="col">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($orderItems)): ?>
							<tr class="text-center">
								<td colspan="1000">No data yet</td>
							</tr>
						<?php else: ?>
							<?php $index = 0; ?>
							<?php foreach ($orderItems as $key => $orderItem): ?>
								<?php $index++; ?>

								<tr>
									<th scope="row">
										<?= $index; ?>
									</th>
									<td class="text-nowrap">
										<a href="/orders/<?= $orderItem->orderCipherId; ?>" class="fw-medium">
											<?= '#' . $orderItem->orderNumber ?>
										</a>
									</td>
									<td class="text-wrap">
										<?= $orderItem->orderDate ?>
									</td>
									<td class="text-nowrap">
										<?= $orderItem->quantity ?>
									</td>
									<td class="text-end text-nowrap color-first-100">
										<?= $orderItem->stringPrice; ?>
									</td>
									<td class="text-end text-nowrap color-first-100">
										<?= $orderItem->stringTotal; ?>
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


<!-- view_modal -->
<?= $this->include('include/view_modal'); ?>


<?= $this->endSection(); ?>