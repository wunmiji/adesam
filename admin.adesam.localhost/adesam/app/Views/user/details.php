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
	'detailsAvatarImageSrc' => $dataImage->fileSrc ?? '/assets/images/avatar-user.png',
	'detailsAvatarImageAlt' => $dataImage->fileName ?? 'Image not set avatar used',
	'name' => $data->name,
	'buttons' => [],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-lg-5 col-md-6 col-12">
		<?php $basicRow = [
			'rows' => [
				'First Name' => $data->firstName,
				'Last Name' => $data->lastName,
				'Email' => $data->email,
				'Number' => $data->number,
				'Description' => $data->description,
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 31, // Add 1rem for gap space
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-lg-7 col-md-6 col-12">
		<div class="card" style="height: 31rem;">
			<div class="card-header card-header-title">Comments</div>
			<div class="card-body overflow-y-auto">

			</div>
		</div>
	</div>
</div>


<?= view_cell('\App\Cells\DetailsCell::addresses', [
	'title' => 'Billing Addresses',
	'dataAdresses' => $dataBillingAdresses
]); ?>

<?= view_cell('\App\Cells\DetailsCell::addresses', [
	'title' => 'Shipping Addresses',
	'dataAdresses' => $dataShippingAdresses
]); ?>

<div class="row my-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header card-header-title">Orders</div>
			<div class="card-body overflow-y-auto">
				<table id="table" class="table table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Number</th>
							<th scope="col">Date</th>
							<th scope="col">Items</th>
							<th scope="col">Status</th>
							<th class="text-end" scope="col">Price</th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($orders)): ?>
							<tr class="text-center">
								<td colspan="1000">No data yet</td>
							</tr>
						<?php else: ?>
							<?php $index = 0; ?>
							<?php foreach ($orders as $key => $order): ?>
								<?php $index++; ?>

								<tr>
									<th scope="row">
										<?= $index; ?>
									</th>
									<td class="text-nowrap">
										<a href="/orders/<?= $order->cipherId; ?>" class="fw-medium">
											<?= '#' . $order->number ?>
										</a>
									</td>
									<td class="text-wrap">
										<?= $order->date ?>
									</td>
									<td class="text-nowrap">
										<?= $order->countItems ?>
									</td>
									<td class="text-nowrap">
										<?= view_cell('\App\Cells\UiCell::orderBadge', ['status' => $order->status]) ?>
									</td>
									<td class="text-end text-nowrap color-first-100">
										<?= $order->stringTotal; ?>
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


<?= $this->endSection(); ?>