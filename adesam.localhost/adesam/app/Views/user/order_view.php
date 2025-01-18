<?= $this->extend('layouts/default_user'); ?>


<!-- sections -->
<?= $this->section('content_user'); ?>



<section>
	<div class="mb-4">
		<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Order Summary']); ?>
	</div>

	<div class="table-responsive scrollbar">
		<table id="table" class="table table-hover">
			<tbody>
				<tr>
					<th scope="row">Number</th>
					<td class="text-nowrap text-end">
						<?= '#' . $data->number; ?>
					</td>
				</tr>
				<tr>
					<th scope="row">Date</th>
					<td class="text-nowrap text-end">
						<?= $data->date; ?>
					</td>
				</tr>
				<tr>
					<th scope="row">Status</th>
					<td class="text-nowrap text-end">
						<?= $data->status; ?>
					</td>
				</tr>
				<tr>
					<th scope="row" class="pe-5">Instruction</th>
					<td class="text-wrap text-end">
						<?= $data->instruction; ?>
					</td>
				</tr>
				<tr>
					<th scope="row">Payment Status</th>
					<td class="text-nowrap text-end">
						<?= $data->paymentStatus; ?>
					</td>
				</tr>
				<tr>
					<th scope="row">Delivery Status</th>
					<td class="text-nowrap text-end">
						<?= $data->deliveryStatus; ?>
					</td>
				</tr>
				<tr>
					<th scope="row" class="text-nowrap">Billing Address</th>
					<td class="text-wrap text-end">
						<?php if (!is_null($data->billingAddress)): ?>
							<?= view_cell('\Cells\MainCell::address', ['dataAddress' => $data->billingAddress]); ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row" class="text-nowrap">Shipping Address</th>
					<td class="text-wrap text-end">
						<?php if (!is_null($data->shippingAddress)): ?>
							<?= view_cell('\Cells\MainCell::address', ['dataAddress' => $data->shippingAddress]); ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr class="border-0">
					<th scope="row" colspan="2" class="border-0 text-nowrap">Products</th>
				</tr>
				<tr>
					<td colspan="2" class="px-0">
						<?php $dataItems = $data->items; ?>
						<div class="table-responsive">
							<table id="table" class="table table-borderless">
								<thead>
									<tr>
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
										<?php foreach ($dataItems as $key => $dataItem): ?>

											<tr>
												<td class="text-wrap">
													<div class="d-flex">
														<div class="flex-shrink-0">
															<img width="70px" height="70px" class="object-fit-cover"
																src="<?= $dataItem->fileSrc; ?>"
																alt="<?= $dataItem->fileName; ?>">
														</div>
														<div class="flex-grow-1 ms-2 d-flex flex-column">
															<a class="mb-0 fw-semibold"
																href="/shop/<?= $dataItem->productUnique; ?>""><?= $dataItem->productName; ?></a>
															<p class=" mb-0"><?= '#' . $dataItem->productUnique; ?></p>
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
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<th scope="row">Subtotal</th>
					<td class="text-nowrap text-end color-first-100">
						<?= $data->stringSubtotal; ?>
					</td>
				</tr>
				<tr>
					<?php $dataShipping = $data->shipping; ?>
					<th class="text-nowrap">Shipping&nbsp;
						<?= '(' . \App\Enums\ShippingType::getValue($dataShipping->type) . ')'; ?>:</th>
					<td class="text-end color-first-100">
						<?= $dataShipping->stringPrice; ?>
					</td>
				</tr>
				<tr>
					<th>Tax:</th>
					<td class="text-end color-first-100">N/A</td>
				</tr>
				<tr>
					<th>Discount:</th>
					<td class="text-end color-first-100">N/A</td>
				</tr>
				<tr>
					<th scope="row">Total</th>
					<td class="text-nowrap text-end color-first-100">
						<?= $data->stringTotal; ?>
					</td>
				</tr>


			</tbody>
		</table>
	</div>
</section>


<?= $this->endSection(); ?>