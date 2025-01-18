<?= $this->extend('layouts/default_settings'); ?>

<?= $this->section('settings_content'); ?>

<div>
    <?php $validation = \Config\Services::validation(); ?>
    <form method="POST" action="/settings?tab=shop" onSubmit="document.getElementById('submit').disabled=true;">
        <?= csrf_field(); ?>

        <div class="mb-4">
            <p>The default currency is Nigerian Naira</p>
            <select class="form-select" id="currencySelect" name="currency" aria-label="Default select example">
                <option selected disabled>Select Currencies</option>
                <?php foreach ($currencies as $key => $currency): ?>
                    <option value='<?= $currency['code']; ?>' <?= ($data->currency->value == $currency['code']) ? 'selected' : ''; ?>>
                        <?= $currency['name'] . ' ' . '(' . $currency['symbol'] . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ($validation->getError('currency')): ?>
                <span class="text-danger text-sm">
                    <?= $error = $validation->getError('currency'); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <p>Shipping price is used in App</p>
            <input type="text" name="shipping-price" id="shipping-price-input" class="form-control"
                value="<?= esc($data->{'shipping-price'}->value); ?>" placeholder="Shipping Price" />
            <?php if ($validation->getError('shipping-price')): ?>
                <span class="text-danger text-sm">
                    <?= $error = $validation->getError('shipping-price'); ?>
                </span>
            <?php endif; ?>
        </div>


        <!-- Submit button -->
        <button type="submit" name="submit" id="submit" class="btn primary-btn">Update</button>
    </form>

</div>

<?= $this->endSection(); ?>