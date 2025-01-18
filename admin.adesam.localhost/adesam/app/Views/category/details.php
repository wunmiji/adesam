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
	'detailsCoverImageSrc' => $dataImage->fileSrc,
	'detailsCoverImageAlt' => $dataImage->fileName,
	'detailsAvatarIcon' => "<i class='bx bx-network-chart bx-lg'></i>",
	'name' => $data->name,
	'updateHref' => '/category/' . $data->cipherId . '/update',
	'deleteHref' => '/category/' . $data->cipherId . '/delete',
	'buttons' => [],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>

<div class="row my-3">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-title">Basic</div>
			<div class="card-body overflow-y-auto">
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Name:</h6>
					<p class="mb-0 flex-fill"><?= $data->name; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Slug:</h6>
					<p class="mb-0 flex-fill"><?= $data->slug; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Number of products:</h6>
					<p class="mb-0 flex-fill"><?= $data->countProducts; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Sum Product Quantity:</h6>
					<p class="mb-0 flex-fill"><?= $sumProductQuantity; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Sum Product Price:</h6>
					<p class="mb-0 flex-fill first-color"><?= $sumProductPrice; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Description:</h6>
					<p class="mb-0 text-wrap flex-fill"><?= $data->description; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Date:</h6>
					<p class="mb-0 flex-fill"><?= $data->date; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Created:</h6>
					<p class="mb-0 flex-fill"><?= $data->createdDateTime; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Last Modified:</h6>
					<p class="mb-0 flex-fill"><?= $data->modifiedDateTime ?? 'Never Modified'; ?></p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row my-3">
	<div class="col-12">
		<div class="card" style="max-height: 25rem;">
			<div class="card-header card-header-title">Products</div>
			<div class="card-body overflow-y-auto">
				<div class="table-responsive">
					<table id="table" class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Status</th>
								<th scope="col">Quantity</th>
								<th class="text-end" scope="col">Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($products)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = 0; ?>
								<?php foreach ($products as $key => $product): ?>
									<?php $productImage = $product->image; ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<div class="d-flex">
												<div class="flex-shrink-0">
													<img width="70px" height="70px" class="object-fit-cover" src="<?= $productImage->fileSrc; ?>" alt="<?= $productImage->fileName; ?>">
												</div>
												<div class="flex-grow-1 ms-2 d-flex flex-column">
													<a class="mb-0 fw-semibold"
														href="/products/<?= \App\Libraries\SecurityLibrary::encryptUrlId($product->id); ?>"><?= $product->name; ?></a>
													<p class="mb-0"><?= '#' . $product->unique; ?></p>
												</div>
											</div>
										</td>
										<td class="text-nowrap">
										<div class="d-flex flex-wrap gap-3">
												<?= view_cell('\App\Cells\UiCell::productStockbadge', params: ['status' => $product->stockStatus]); ?>
												<?= view_cell('\App\Cells\UiCell::productVisibiltybadge', ['status' => $product->visibilityStatus]); ?>
											</div>
										</td>
										<td class="text-nowrap">
											<?= $product->quantity ?>
										</td>
										<td class="text-end text-nowrap first-color">
											<?= $product->stringActualSellingPrice ?>
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

<!-- data_text -->
<?= $this->include('include/data_text'); ?>


<?= $this->endSection(); ?>