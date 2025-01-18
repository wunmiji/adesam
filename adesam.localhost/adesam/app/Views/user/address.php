<?= $this->extend('layouts/default_user'); ?>


<!-- sections -->
<?= $this->section('content_user'); ?>


<section>
	<?php $validation = \Config\Services::validation(); ?>
	<?= view_cell('\Cells\AlertCell::alertPost'); ?>
</section>



<section>
	<div class="mb-4">
		<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Billing Address']); ?>
	</div>
	<div class="row row-cols-md-3 row-cols-sm-2 row-cols-1 g-4 align-items-center">
		<?php if (empty($dataBillingAddresses)): ?>
			<div class="col">
				<p>No Data yet</p>
			</div>
		<?php else: ?>
			<?php foreach ($dataBillingAddresses as $dataAddress): ?>
				<div class="col">
					<?= view_cell('\Cells\MainCell::address', ['dataAddress' => $dataAddress]); ?>
					<div class="d-flex align-items-center column-gap-2">
						<a class="btn px-0 mt-2" data-bs-toggle="modal" data-bs-target="#addressModal"
							data-cipher="<?= \App\Libraries\SecurityLibrary::encryptUrlId($dataAddress->id); ?>"
							data-title="Billing Address" data-address="<?= esc(json_encode($dataAddress)); ?>"
							data-action="/user?tab=address" data-method="update" data-type="billing">Edit</a>
						<a href="/user?tab=address&type=billing&cipher=<?= \App\Libraries\SecurityLibrary::encryptUrlId($dataAddress->id); ?>"
							class="btn px-0 mt-2">Remove</a>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<?= view_cell('\Cells\MainCell::addAddress', [
			'target' => '#addressModal',
			'title' => 'Billing Address',
			'action' => '/user?tab=address',
			'type' => 'billing',
			'method' => 'create'
		]); ?>
	</div>
</section>

<section class="mt-4">
	<div class="mb-4">
		<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Shipping Address']); ?>
	</div>
	<div class="row row-cols-md-3 row-cols-sm-2 row-cols-1 g-4 align-items-center">
		<?php if (empty($dataShippingAddresses)): ?>
			<div class="col">
				<p>No Data yet</p>
			</div>
		<?php else: ?>
			<?php foreach ($dataShippingAddresses as $dataAddress): ?>
				<div class="col">
					<?= view_cell('\Cells\MainCell::address', ['dataAddress' => $dataAddress]); ?>
					<div class="d-flex align-items-center column-gap-2">
						<a class="btn px-0 mt-2" data-bs-toggle="modal" data-bs-target="#addressModal"
							data-cipher="<?= \App\Libraries\SecurityLibrary::encryptUrlId($dataAddress->id); ?>"
							data-title="Shipping Address" data-address="<?= esc(json_encode($dataAddress)); ?>"
							data-action="/user?tab=address" data-method="update" data-type="shipping">Edit</a>
							<a href="/user?tab=address&type=shipping&cipher=<?= \App\Libraries\SecurityLibrary::encryptUrlId($dataAddress->id); ?>"
							class="btn px-0 mt-2">Remove</a>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
		<?= view_cell('\Cells\MainCell::addAddress', [
			'target' => '#addressModal',
			'title' => 'Shipping Address',
			'action' => '/user?tab=address',
			'type' => 'shipping',
			'method' => 'create'
		]); ?>
	</div>
</section>


<!-- address_modal -->
<?= $this->include('include/address_modal'); ?>


<?= $this->endSection(); ?>