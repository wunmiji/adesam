<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a href="/calendar/create?date=<?= $dataDate; ?>" class="btn primary-btn">New Calendar</a>'
	]
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<!-- all -->
<div class="row my-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header card-header-title"><?= $dataDateString; ?></div>
			<div class="card-body">

				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Title</th>
								<th scope="col">Type</th>
								<th scope="col">Start</th>
								<th scope="col">End</th>
								<th scope="col">Details</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($datas)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = 0; ?>
								<?php foreach ($datas as $key => $data): ?>
									<?php $dataImage = $data->image; ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<div class="d-flex">
												<div class="flex-shrink-0">
													<img width="50px" height="50px" class="object-fit-cover"
														src="<?= $dataImage->fileSrc ?? '/assets/images/calendar-image.png'; ?>"
														alt="<?= $dataImage->fileName ?? 'Image not set calender image used'; ?>">
												</div>
												<div class="flex-grow-1 ms-2 d-flex">
													<h6 class="mb-0"><?= $data->title; ?></h6>
												</div>
											</div>
										</td>
										<td class="text-nowrap">
											<?= view_cell('\App\Cells\UiCell::calendarBadge', ['type' => $data->type]); ?>
										</td>
										<td class="text-nowrap">
											<div class="d-flex flex-column">
												<p class="mb-0"><?= $data->start; ?></p>
												<p class="mb-0"><?= \App\Libraries\DateLibrary::formatTime($data->startTime); ?>
												</p>
											</div>
										</td>
										<td class="text-nowrap">
											<div class="d-flex flex-column">
												<p class="mb-0"><?= $data->end ?? $data->start; ?></p>
												<p class="mb-0">
													<?= $data->endTime ?? \App\Libraries\DateLibrary::formatTime('23:59'); ?>
												</p>
											</div>
										</td>
										<td class="text-nowrap">
											<a href="<?= $dataDate . '/' . $data->cipherId; ?>"
												class="btn primary-btn">Details</a>
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