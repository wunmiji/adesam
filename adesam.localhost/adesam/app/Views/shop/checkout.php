<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Checkout',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/shop' => 'Shop'],
	'dataCarouselBreadCrumbActive' => 'Checkout',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>


<div class="mb-5">

    <?php if (!empty(session()->getFlashData('success'))): ?>
        <div class="text-center">
            <h2 class="mb-3"><?= session()->getFlashData('success'); ?></h2>
            <p>Order processing soon. </p>
            <a href="/shop" class="btn primary-btn">RETURN TO SHOP</a>
        </div>
    <?php elseif (!empty(session()->getFlashData('fail'))): ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class='bx bxs-error me-2'></i>
            <div>
                <?= session()->getFlashData('fail'); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php $validation = \Config\Services::validation(); ?>


    <?php if (empty(session()->getFlashData('success'))): ?>
        <div class="row justify-content-center g-5">
            <?php $items = $data->items; ?>
            <?php if (empty($items)): ?>
                <?= view_cell('\App\Cells\MainCell::emptyCart'); ?>
            <?php else: ?>
                <div class="col-lg-7 col-12">
                    <div class="mb-3">
                        <textarea class="form-control" name="instruction" id="instruction-textarea" rows="5"
                            placeholder="Instructions about your order, e.g special instructions for delivery."></textarea>
                    </div>

                    <?php if ($data->shippingType == \App\Enums\ShippingType::FLAT_RATE->name): ?>
                        <div>
                            <h4>Shipping Address</h4>
                            <div class="row row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
                                <?php $indexShippingAddress = 0; ?>
                                <?php foreach ($dataShippingAddresses as $dataShippingAddress): ?>
                                    <?php $indexShippingAddress++; ?>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                value="<?= esc(json_encode($dataShippingAddress)); ?>" name="shippingAddressRadio"
                                                id="shippingAddressRadio<?= $indexShippingAddress; ?>">
                                            <label for="shippingAddressRadio<?= $indexShippingAddress; ?>">
                                                <?= view_cell('\Cells\MainCell::address', ['dataAddress' => $dataShippingAddress]); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?= view_cell('\Cells\MainCell::addAddress', [
                                    'target' => '#addressModal',
                                    'title' => 'Shipping Address',
                                    'action' => '/user/shipping-address'
                                ]); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($data->paymentMethod == \App\Enums\PaymentMethod::CREDIT_CARD->name): ?>
                        <div>
                            <h4>Billing Address</h4>
                            <div class="row row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
                                <?php $indexBillingAddress = 0; ?>
                                <?php foreach ($dataBillingAddresses as $dataBillingAddress): ?>
                                    <?php $indexBillingAddress++; ?>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                value="<?= esc(json_encode($dataBillingAddress)); ?>" name="billingAddressRadio"
                                                id="billingAddressRadio<?= $indexBillingAddress; ?>">
                                            <label for="billingAddressRadio<?= $indexBillingAddress; ?>">
                                                <?= view_cell('\Cells\MainCell::address', ['dataAddress' => $dataBillingAddress]); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?= view_cell('\Cells\MainCell::addAddress', [
                                    'target' => '#addressModal',
                                    'title' => 'Billing Address',
                                    'action' => '/user/billing-address'
                                ]); ?>
                            </div>
                        </div>
                        <div>
                            <!-- Card Number -->
                            <div class="mb-4">
                                <input type="text" name="card_number" id="cardNumberInput" class="form-control"
                                    value="<?= set_value('card_number'); ?>" placeholder="Card Number" />
                                <?php if ($validation->getError('card_number')): ?>
                                    <span class="text-danger text-sm">
                                        <?= $error = $validation->getError('card_number'); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Date Field -->
                            <div class="row row-cols-lg-2 row-cols-1 mb-4">
                                <div class="col">
                                    <select class="form-select" name="Month">
                                        <option value="january">January</option>
                                        <option value="february">February</option>
                                        <option value="march">March</option>
                                        <option value="april">April</option>
                                        <option value="may">May</option>
                                        <option value="june">June</option>
                                        <option value="july">July</option>
                                        <option value="august">August</option>
                                        <option value="september">September</option>
                                        <option value="october">October</option>
                                        <option value="november">November</option>
                                        <option value="december">December</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-select" name="Year">
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Card Verification Field -->
                            <div class="row row-cols-lg-2 row-cols-1 mb-4">
                                <div class="col">
                                    <input type="text" name="ccv" id="cardNumberInput" class="form-control"
                                        value="<?= set_value('ccv'); ?>" placeholder="CCV" />
                                    <?php if ($validation->getError('ccv')): ?>
                                        <span class="text-danger text-sm">
                                            <?= $error = $validation->getError('ccv'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <p class="mb-0">3 or 4 digits usually found on the signature strip</p>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($data->paymentMethod == \App\Enums\PaymentMethod::CASH->name): ?>
                        <p>Pay with cash upon delivery.</p>
                    <?php elseif ($data->paymentMethod == \App\Enums\PaymentMethod::BANK_TRANSFER->name): ?>
                        <p>We kindly request that you transfer your payment directly to our bank account,
                            ensuring to include your Order ID as the payment reference. Please be aware that
                            your order will not be ready for delivery until the funds have been cleared in our
                            account.</p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="d-flex flex-column row-gap-4">
                        <?php $dataItems = $data->items; ?>
                        <div id="your-order-container" data-currency="<?= esc($currency); ?>"
                            data-items="<?= esc(json_encode($dataItems)); ?>">
                            <h4>Your Order</h4>
                        </div>

                        <div id="order-summary-container">
                            <h4>Order Summary</h4>
                            <div class="d-flex flex-column row-gap-3">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Subtotal</p>
                                    <h6 class="mb-0 color-first-100" id="subtotal-h6"></h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Shipping</p>
                                    <div class="d-flex flex-column align-items-end">
                                        <h6 class="mb-0"><?= \App\Enums\ShippingType::getValue($data->shippingType); ?></h6>
                                        <span class="color-first-100" id="shipping-price-span"
                                            data-shipping-price="<?= $shippingPrice; ?>"></span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0">Payment</p>
                                    <h6 class="mb-0"><?= \App\Enums\PaymentMethod::getValue($data->paymentMethod); ?></h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="fw-semibold mb-0">Total</p>
                                    <h5 class="mb-0 color-first-100" id="total-h5"></h5>
                                </div>
                            </div>
                        </div>

                        <div>
                            <form method="POST" action="/shop/checkout"
                                onSubmit="document.getElementById('order-btn').disabled=true;">

                                <input type="hidden" name="items" value="<?= esc(json_encode($data->items)); ?>">
                                <input type="hidden" name="instruction" id="instruction">
                                <input type="hidden" name="subtotal" id="subtotal">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="shipping-type" value="<?= $data->shippingType; ?>">
                                <input type="hidden" name="shipping-price" value="<?= $shippingPrice; ?>">
                                <input type="hidden" name="billing-address" id="billing-address">
                                <input type="hidden" name="shipping-address" id="shipping-address">
                                <input type="hidden" name="payment-method" id="payment-method"
                                    value="<?= $data->paymentMethod; ?>">

                                <button type="submit" name="submit" id="order-btn" class="btn primary-btn w-100 py-2">Place
                                    Order</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- address_modal -->
<?= $this->include('include/address_modal'); ?>



<?= $this->endSection(); ?>