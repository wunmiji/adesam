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
	'detailsAvatarIcon' => "<i class='bx bx-box bx-lg white-color'></i>",
	'name' => '#' . $data->number,
	'deleteHref' => '/orders/' . $data->cipherId . '/delete',
	'buttons' => [
	],
] ?>
<?php if ($data->status == \App\Enums\OrderStatus::NEW ->name || $data->status == \App\Enums\OrderStatus::PARTIAL_PAID->name): ?>
	<?php array_push($dataCardHeader['buttons'], '<a class="btn primary-btn" data-bs-toggle="modal" data-bs-target="#cashPaymentModal" >Add Cash Payment</a>'); ?>
	<?php array_push($dataCardHeader['buttons'], '<a class="btn primary-btn" data-bs-toggle="modal" data-bs-target="#bankTraasferPaymentModal" >Add Bank Transfer Payment</a>'); ?>
<?php endif; ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row row-cols-md-2 row-cols-1 g-3 my-3">
	<div class="col">
		<div class="card" style="height: 12rem;">
			<div class="card-header card-header-title">Order Info</div>
			<div class="card-body overflow-y-auto">
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Number:</h6>
					<p class="mb-0"><?= $data->number; ?></p>
				</div>
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Status:</h6>
					<p class="mb-0"><?= \App\Enums\OrderStatus::getValue($data->status); ?></p>
				</div>
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Payment Status:</h6>
					<p class="mb-0"><?= \App\Enums\PaymentStatus::getValue($data->paymentStatus); ?></p>
				</div>
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Delivery Status:</h6>
					<p class="mb-0"><?= \App\Enums\DeliveryStatus::getValue($data->deliveryStatus); ?></p>
				</div>
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Instruction:</h6>
					<p class="mb-0"><?= $data->instruction; ?></p>
				</div>
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Date:</h6>
					<p class="mb-0"><?= $data->date; ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card" style="height: 12rem;">
			<div class="card-header card-header-title">Customer Info</div>
			<div class="card-body overflow-y-auto">
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Name:</h6>
					<p class="mb-0"><?= $data->userName; ?></p>
				</div>
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Email:</h6>
					<p class="mb-0"><?= $data->userEmail; ?></p>
				</div>
				<div class="d-flex flex-wrap column-gap-2">
					<h6 class="mb-0">Phone Number:</h6>
					<p class="mb-0"><?= $data->userNumber; ?></p>
				</div>
				<div class="mt-3">
					<a class="btn primary-btn" href="/users/<?= $data->userCipherId; ?>">View Profile</a>
				</div>
			</div>
		</div>
	</div>

	<?php if (!is_null($dataBillingAdress)): ?>
		<div class="col">
			<div class="card" style="max-height: 12rem;">
				<div class="card-header card-header-title">Billing Info</div>
				<div class="card-body overflow-y-auto">
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Name:</h6>
						<p class="mb-0"><?= $dataBillingAdress->name; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Address:</h6>
						<p class="mb-0"><?= $dataBillingAdress->addressOne; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Address (Optional):</h6>
						<p class="mb-0"><?= $dataBillingAdress->addressTwo; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">City:</h6>
						<p class="mb-0"><?= $dataBillingAdress->city; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Postal Code:</h6>
						<p class="mb-0"><?= $dataBillingAdress->postalCode; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">State:</h6>
						<p class="mb-0">
							<?= $dataBillingAdress->stateName . ' (' . $dataBillingAdress->stateCode . ')'; ?>
						</p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Counry:</h6>
						<p class="mb-0">
							<?= $dataBillingAdress->countryName . ' (' . $dataBillingAdress->countryCode . ')'; ?>
						</p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Email:</h6>
						<p class="mb-0"><?= $dataBillingAdress->email; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Phone Number:</h6>
						<p class="mb-0"><?= $dataBillingAdress->number; ?></p>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if (!is_null($dataShippingAdress)): ?>
		<div class="col">
			<div class="card" style="max-height: 12rem;">
				<div class="card-header card-header-title">Shipping Info</div>
				<div class="card-body overflow-y-auto">
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Name:</h6>
						<p class="mb-0"><?= $dataShippingAdress->name; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Address:</h6>
						<p class="mb-0"><?= $dataShippingAdress->addressOne; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Address (Optional):</h6>
						<p class="mb-0"><?= $dataShippingAdress->addressTwo; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">City:</h6>
						<p class="mb-0"><?= $dataShippingAdress->city; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Postal Code:</h6>
						<p class="mb-0"><?= $dataShippingAdress->postalCode; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">State:</h6>
						<p class="mb-0">
							<?= $dataShippingAdress->stateName . ' (' . $dataShippingAdress->stateCode . ')'; ?>
						</p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Counry:</h6>
						<p class="mb-0">
							<?= $dataShippingAdress->countryName . ' (' . $dataShippingAdress->countryCode . ')'; ?>
						</p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Email:</h6>
						<p class="mb-0"><?= $dataShippingAdress->email; ?></p>
					</div>
					<div class="d-flex flex-wrap column-gap-2">
						<h6 class="mb-0">Phone Number:</h6>
						<p class="mb-0"><?= $dataShippingAdress->number; ?></p>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>

<!-- data_items -->
<div class="row my-3">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-title">Items</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table" class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th class="text-end" scope="col">Amount</th>
								<th scope="col">Quantity</th>
								<th class="text-end" scope="col">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($dataItems)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = 0; ?>
								<?php foreach ($dataItems as $key => $dataItem): ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<div class="d-flex">
												<div class="flex-shrink-0">
													<img width="70px" height="70px" class="object-fit-cover"
														src="<?= $dataItem->fileSrc; ?>" alt="<?= $dataItem->fileName; ?>">
												</div>
												<div class="flex-grow-1 ms-2 d-flex flex-column">
													<a class="mb-0 fw-semibold"
														href="/products/<?= $dataItem->productCipherId; ?>"><?= $dataItem->productName; ?></a>
													<p class="mb-0"><?= '#' . $dataItem->productUnique; ?></p>
												</div>
											</div>
										</td>
										<td class="text-end text-nowrap color-first-100">
											<?= $dataItem->stringPrice ?>
										</td>
										<td class="text-nowrap">
											<?= $dataItem->quantity ?>
										</td>
										<td class="text-end text-nowrap color-first-100">
											<?= $dataItem->stringTotal ?>
										</td>
									</tr>
								<?php endforeach; ?>

								<tr>
									<td colspan="3"></td>
									<td colspan="2" class="p-0">
										<table class="table table-borderless mb-0">
											<tbody>
												<tr>
													<td>Subtotal:</td>
													<td class="text-end color-first-100"><?= $data->stringSubtotal; ?></td>
												</tr>
												<tr>
													<td>Shipping<?= '(' . \App\Enums\ShippingType::getValue($dataShipping->type) . ')'; ?>:
													</td>
													<td class="text-end color-first-100"><?= $dataShipping->stringPrice; ?></td>
												</tr>
												<tr>
													<td>Tax:</td>
													<td class="text-end color-first-100">N/A</td>
												</tr>
												<tr>
													<td>Discount:</td>
													<td class="text-end color-first-100">N/A</td>
												</tr>
												<tr class="border-top">
													<th>Total:</th>
													<th class="text-end color-first-100"><?= $data->stringTotal; ?></th>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- data_payments -->
<div class="row my-3">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-title">Payments</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table" class="table">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Method</th>
								<th scope="col">Date</th>
								<th scope="col">Status</th>
								<th class="text-end" scope="col">Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($dataPayments)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = 0; ?>
								<?php foreach ($dataPayments as $key => $dataPayment): ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<?= $dataPayment->name; ?>
										</td>
										<td class="text-wrap">
											<?= \App\Enums\PaymentMethod::getValue($dataPayment->method); ?>
										</td>
										<td class="text-wrap">
											<?= $dataPayment->createdDateTime; ?>
										</td>
										<td class="text-nowrap">
											<?= view_cell('\App\Cells\UiCell::paymentBadge', ['status' => $dataPayment->status]) ?>
										</td>
										<td class="text-end text-nowrap color-first-100">
											<?= $dataPayment->stringAmount ?>
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

<!-- data_tracking -->
<div class="row my-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header card-header-title">Tracking</div>
			<div class="card-body">

			</div>
		</div>
	</div>
</div>


<!-- New Payment modal -->
<div class="modal fade" id="cashPaymentModal" tabindex="-1" aria-tagledby="cashPaymentModalTag" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">New Cash Payment</div>
			</div>
			<div class="modal-body" id="cashPaymentModalBodyDiv">
				<form method="POST" id="cashPaymentModalForm"
					action="<?= '/orders/' . $data->cipherId . '/create-cash-payment'; ?>"
					onSubmit="document.getElementById('submitDiscount').disabled=true;">
					<div class="mb-4">
						<input type="text" name="name" id="nameModalInput" class="form-control"
							placeholder="Enter Name" />
					</div>

					<div class="mb-4">
						<div class="col">
							<input type="text" name="amount" id="amountInput" class="form-control"
								placeholder="Enter Amount" />
						</div>
					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" id="submitDiscount" class="btn primary-btn">Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>