<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a href="/products/create" class="btn primary-btn">New Product</a>',
		'<a href="/products/tags" class="btn primary-btn">Tags</a>',
		'<a href="/products/discounts" class="btn primary-btn">Discounts</a>'
	]
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?= $this->include('include/search_table_and_pagination_limit'); ?>

				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Status</th>
								<th scope="col">Price</th>
								<th scope="col">Quantity</th>
								<th scope="col">Details</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($datas)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = ($queryPage - 1) * $queryLimit; ?>
								<?php foreach ($datas as $key => $data): ?>
									<?php $dataImage = $data->image; ?>
									<?php $dataTags = $data->tags; ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<div class="d-flex">
												<div class="flex-shrink-0">
													<img width="70px" height="70px" class="object-fit-cover"
														src="<?= $dataImage->fileSrc; ?>" alt="<?= $dataImage->fileName; ?>">
												</div>
												<div class="flex-grow-1 ms-2 d-flex flex-column">
													<h6 class="mb-0"><?= $data->name; ?></h6>
													<p class="mb-0"><?= '#' . $data->unique; ?></p>
													<div class="d-flex flex-wrap gap-1">
														<?php foreach ($dataTags as $key => $dataTag): ?>
															<?= view_cell('\App\Cells\UiCell::tagBadge', ['name' => $dataTag->tagName]) ?>
														<?php endforeach; ?>
													</div>
												</div>
											</div>
										</td>
										<td class="text-nowrap">
											<div class="d-flex flex-wrap gap-2">
												<?= view_cell('\App\Cells\UiCell::productStockbadge', ['status' => $data->stockStatus]); ?>
												<?= view_cell('\App\Cells\UiCell::productVisibiltybadge', ['status' => $data->visibilityStatus]); ?>
											</div>
										</td>
										<td class="text-nowrap color-first-100">
											<?= $data->stringActualSellingPrice; ?>
										</td>
										<td class="text-nowrap">
											<?= $data->quantity; ?>
										</td>
										<td class="text-nowrap">
											<a href="/products/<?= $data->cipherId; ?>" class="btn primary-btn">Details</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>

				<?= $this->include('include/pagination'); ?>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>