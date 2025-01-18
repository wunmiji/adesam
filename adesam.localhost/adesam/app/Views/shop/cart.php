<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Shopping Cart',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/shop' => 'Shop'],
	'dataCarouselBreadCrumbActive' => 'Cart',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>



<div class="mb-5">
	<div class="row justify-content-center g-5">
		<div class="col-12">
			<?= view_cell('\App\Cells\AlertCell::alertPost'); ?>

			<div id="cart-table" data-user="<?= var_export(session()->has('userId')); ?>"
				data-currency="<?= esc($currency); ?>"
				data-cart="<?= (session()->has('userId') == true) ? esc(json_encode($data)) : null; ?>">
			</div>


			<div class="my-5">
				<table id="totalTable" class="table">
					<tbody>
						<tr>
							<td class="py-4 fw-medium">SubTotal</td>
							<td class="py-4 color-first-100" id="total_table_subtotal"></td>
						</tr>
						<tr>
							<td class="py-4 fw-medium">Shipping</td>
							<td class="py-4">
								<div class="d-flex flex-column row-gap-3">
									<div class="d-flex align-items-center column-gap-2">
										<input class="form-check-input" type="radio" name="shipping-radio"
											id="localPickupRadio" value="0"
											data-enum="<?= \App\Enums\ShippingType::LOCAL_PICKUP->name; ?>">
										<label class="form-check-label" for="localPickupRadio">
											<?= \App\Enums\ShippingType::LOCAL_PICKUP->value; ?>
										</label>
									</div>
									<div class="d-flex align-items-center column-gap-2">
										<input class="form-check-input" type="radio" name="shipping-radio"
											id="flatRateRadio" value="<?= $shippingPrice; ?>"
											data-enum="<?= \App\Enums\ShippingType::FLAT_RATE->name; ?>">
										<label class="form-check-label" for="flatRateRadio">
											<?= \App\Enums\ShippingType::FLAT_RATE->value . ' (' ?>
											<span class="color-first-100"><?= $stringShippingPrice; ?></span>
											<?= ' )'; ?>
										</label>
									</div>

								</div>
							</td>
						</tr>
						<tr>
							<td class="py-4 fw-medium">Payment Options</td>
							<td class="py-4 text-wrap">
								<div class="d-flex flex-column row-gap-3">
									<?php $indexPaymentRadio = 0; ?>
									<?php foreach ($paymentMethods as $paymentMethodsKey => $paymentMethod): ?>
										<?php $indexPaymentRadio++; ?>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="payment"
												id="payment-radio<?= '-' . $indexPaymentRadio; ?>"
												value="<?= $paymentMethodsKey; ?>">
											<label class="form-check-label"
												for="payment-radio<?= '-' . $indexPaymentRadio; ?>">
												<?= $paymentMethod; ?>
											</label>
										</div>
									<?php endforeach; ?>
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-4 fw-medium">Total</td>
							<td class="py-4 fs-5 fw-semibold color-first-100" id="total_table_total"></td>
						</tr>
					</tbody>
				</table>
				<div class="d-flex column-gap-3">
					<a href="/shop/cart/empty-cart" class="btn primary-btn" id="empty-cart-btn">EMPTY SHOPPING CART</a>

					<button type="submit" name="submit" class="btn primary-btn" id="update-cart-btn">UPDATE CART</button>

					<a href="/shop/checkout" class="btn primary-btn fw-medium flex-fill">PROCEED TO
						CHECKOUT</a>
				</div>
			</div>
		</div>
	</div>

</div>


<?= $this->endSection(); ?>