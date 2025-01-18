<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="pt-4 row row-cols-md-3 row-cols-lg-6 row-cols-2 g-4 mb-3">
	<div class="col">
		<div class="card h-100">
			<div class="card-body">
				<div class="text-center">
					<i class='bx bx-group display-5 mb-2' style="color: var(--dashboard-contact);"></i>
					<p class="fw-semibold fs-6 skin-color mb-1">Contacts</p>
					<h5 class="fw-semibold mb-0 gray-color"><?= $contactTotal; ?></h5>
				</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card h-100">
			<div class="card-body">
				<div class="text-center">
					<i class='bx bx-calendar-event display-5 mb-2' style="color: var(--dashboard-occasion);"></i>
					<p class="fw-semibold fs-6 skin-color mb-1">Occasions</p>
					<h5 class="fw-semibold mb-0 gray-color"><?= $occasionTotal; ?></h5>
				</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card h-100">
			<div class="card-body">
				<div class="text-center">
					<i class='bx bxs-t-shirt display-5 mb-2' style="color: var(--dashboard-product);"></i>
					<p class="fw-semibold fs-6 skin-color mb-1">Products</p>
					<h5 class="fw-semibold mb-0 gray-color"><?= $productTotal; ?></h5>
				</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card h-100">
			<div class="card-body">
				<div class="text-center">
					<i class='bx bx-box display-5 mb-2' style="color: var(--dashboard-order);"></i>
					<p class="fw-semibold fs-6 skin-color mb-1">Orders</p>
					<h5 class="fw-semibold mb-0 gray-color"><?= $orderTotal; ?></h5>
				</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card h-100">
			<div class="card-body">
				<div class="text-center">
					<i class='bx bx-user display-5 mb-2' style="color: var(--dashboard-user);"></i>
					<p class="fw-semibold fs-6 skin-color mb-1">Users</p>
					<h5 class="fw-semibold mb-0 gray-color"><?= $userTotal; ?></h5>
				</div>
			</div>
		</div>
	</div>

	<div class="col">
		<div class="card h-100">
			<div class="card-body">
				<div class="text-center">
					<i class='bx bx-folder display-5 mb-2' style="color: #606C38;"></i>
					<p class="fw-semibold fs-6 skin-color mb-1">File Manager</p>
					<h5 class="fw-semibold mb-0 gray-color"><?= $fileTotal; ?></h5>
				</div>
			</div>
		</div>
	</div>


</div>

<div class="row g-4 mb-3">
	<div class="col-md-12 col-12">
		<div class="card" style="height: 20rem;">
			<div class="card-header d-flex justify-content-between">
				<div class="card-header-title">Insight</div>
				<div>
					<select class="form-select" id="insightPerMonthYear" aria-label="Default select example">
						<option disabled>Year</option>
						<?php for ($i = $founded; $i <= date('Y'); $i++): ?>
							<option value="<?= $i; ?>" <?= ($i == date('Y')) ? 'selected' : ''; ?>><?= $i; ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>
			<div class="card-body overflow-y-auto">
				<canvas id="insightCanvas" class="w-100" style="height: 97%;">
					<p>Your browser does not support the canvas element.</p>
				</canvas>
			</div>
		</div>
	</div>
</div>

<div class="row g-4 mb-3">
	<div class="col-md-6 col-12">
		<div class="card" style="max-height: 30rem;">
			<div class="card-header card-header-title">Recent Payments</div>
			<div class="card-body overflow-y-auto">
				<?php if (empty($payments)): ?>
					<p>No data yet</p>
				<?php else: ?>
					<ul class="list-group list-group-flush">
						<?php foreach ($payments as $key => $payment): ?>
							<li class="list-group-item px-0">
								<div class="d-flex">
									<div class="flex-shrink-0">
										<?php if ($payment->method == \App\Enums\PaymentMethod::CASH->name): ?>
											<div class="d-flex justify-content-center align-items-center p-2"
												style="border-radius: 0.25rem; background-color: <?= \App\Enums\PaymentMethod::CASH->color() . '30'; ?>">
												<i class='bx bx-money'
													style="color: <?= \App\Enums\PaymentMethod::CASH->color(); ?>"></i>
											</div>
										<?php elseif ($payment->method == \App\Enums\PaymentMethod::BANK_TRANSFER->name): ?>
											<div class=" d-flex justify-content-center align-items-center p-2"
												style="border-radius: 0.25rem; background-color: <?= \App\Enums\PaymentMethod::BANK_TRANSFER->color() . '30'; ?>">
												<i class='bx bxs-bank'
													style="color: <?= \App\Enums\PaymentMethod::BANK_TRANSFER->color(); ?>"></i>
											</div>
										<?php elseif ($payment->method == \App\Enums\PaymentMethod::CREDIT_CARD->name): ?>
											<div class="d-flex justify-content-center align-items-center p-2"
												style="border-radius: 0.25rem; background-color: <?= \App\Enums\PaymentMethod::CREDIT_CARD->color() . '30'; ?>">
												<i class='bx bx-credit-card'
													style="color: <?= \App\Enums\PaymentMethod::CREDIT_CARD->color(); ?>"></i>
											</div>
										<?php elseif ($payment->method == \App\Enums\PaymentMethod::PAYPAL->name): ?>
											<div class="d-flex justify-content-center align-items-center p-2"
												style="border-radius: 0.25rem; background-color: <?= \App\Enums\PaymentMethod::PAYPAL->color() . '30'; ?>">
												<i class='bx bxl-paypal'
													style="color: <?= \App\Enums\PaymentMethod::PAYPAL->color(); ?>"></i>
											</div>
										<?php endif ?>
									</div>
									<div class="flex-grow-1 ms-2">
										<div class="d-flex justify-content-between">
											<div class="d-flex column-gap-2">
												<a class="mb-0 fw-medium" href="/orders/<?= $payment->orderCipherId; ?>">
													<?= '#' . $payment->orderNumber; ?>
												</a>
												<p class="mb-0">|</p>
												<p class="mb-0 fs-6"><?= $payment->name; ?></p>
											</div>
											<div class="">
												<p class="mb-0 first-color"><?= $payment->stringAmount; ?></p>
											</div>
										</div>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-12">
		<div class="card" style="max-height: 30rem;">
			<div class="card-header card-header-title">Calendar</div>
			<div class="card-body overflow-y-auto">
				<div class="d-flex flex-column row-gap-2">
					<?php if (empty($calendars)): ?>
						<p>No data yet</p>
					<?php else: ?>
						<?php foreach ($calendars as $key => $calendar): ?>
							<?php $calendarDataImage = $calendar->image; ?>
							<div class="d-flex p-2"
								style="background-color: <?= $calendar->backgroundColor . '35'; ?>; border-radius: 0.25rem;">
								<div class="flex-shrink-0">
									<img style="border-radius: 0.25rem;" width="65px" height="65px" class="object-fit-cover"
										src="<?= $calendarDataImage->fileSrc ?? '/assets/images/calendar-image.png'; ?>"
										alt="<?= $calendarDataImage->fileName ?? 'Image not set calender image used'; ?>">
								</div>
								<div class="flex-grow-1 ms-3 d-flex flex-column">
									<a href="/calendar/<?= $calendar->start; ?>/<?= $calendar->cipherId; ?>"
										class="mb-0 fw-semibold"><?= $calendar->title; ?></a>
									<?php if (is_null($calendar->end)): ?>
										<p class="mb-0"><?= $calendar->stringStart; ?></p>
									<?php else: ?>
										<div class="d-flex flex-column">
													<p class="mb-0"><?= $calendar->stringStart . ' ' . $calendar->stringStartTime; ?></p>
													<i class='bx bx-chevrons-right'></i>
													<p class="mb-0"><?= $calendar->stringEnd . ' ' . $calendar->stringEndTime; ?></p>
												</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row g-4">
	<div class="col-md-12 col-12">
		<div class="card">
			<div class="card-header card-header-title">Recent Orders</div>
			<div class="card-body overflow-y-auto">
				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover">

						<tbody>
							<?php if (empty($orders)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = 0; ?>
								<?php foreach ($orders as $key => $order): ?>
									<tr>
										<td class="text-nowrap">
											<div class="d-flex flex-column">
												<p class="mb-0 fs-8">Number</p>
												<a href="/orders/<?= $order->cipherId; ?>"
													class="mb-0 fw-medium"><?= '#' . $order->number ?></a>
											</div>
										</td>
										<td class="text-wrap">
											<div class="d-flex flex-column">
												<p class="mb-0 fs-8">Name</p>
												<a href="/users/<?= $order->userCipherId; ?>"
													class="mb-0 fw-medium"><?= $order->userName ?></a>
											</div>
										</td>
										<td class="text-nowrap">
											<div class="d-flex flex-column">
												<p class="mb-0 fs-8">Items</p>
												<p class="mb-0 fw-medium"><?= $order->countItems ?></p>
											</div>
										</td>
										<td class="text-nowrap">
											<div class="d-flex flex-column">
												<p class="mb-1 fs-8">Status</p>
												<p class="mb-0 fw-medium">
													<?= view_cell('\App\Cells\UiCell::orderbadge', ['status' => $order->status]) ?>
												</p>
											</div>
										</td>
										<td class="text-end text-nowrap">
											<div class="d-flex flex-column">
												<p class="mb-0 fs-8">Price</p>
												<p class="mb-0 fw-medium first-color"><?= $order->stringTotal ?></p>
											</div>
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

<?= $this->endSection(); ?>