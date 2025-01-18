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
	'detailsCoverImageSrc' => $dataImage->fileSrc,
	'detailsCoverImageAlt' => $dataImage->fileName,
	'detailsAvatarIcon' => "<i class='bx bx-party bx-lg white-color'></i>",
	'name' => $data->title,
	'updateHref' => '/occasions/' . $data->cipherId . '/update',
	'deleteHref' => '/occasions/' . $data->cipherId . '/delete',
	'buttons' => [],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-lg-5 col-md-6 col-12">
		<?php $basicRow = [
			'rows' => [
				'Title' => $data->title,
				'Status' => view_cell('\App\Cells\UiCell::occasionBadge', ['status' => $data->status]),
				'Published Date' => $data->publishedDate ?? 'Not Published',
				'Summary' => $data->summary,
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 30, // Add 1rem for gap space
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-lg-7 col-md-6 col-12">
		<div class="row g-3">
			<div class="col-12">
				<div class="card" style="height: 10.5rem;">
					<div class="card-header card-header-title">Calendar</div>
					<div class="card-body overflow-y-auto">
						<?php if (is_null($calendar)): ?>
							<small>No data yet</small>
						<?php else: ?>
							<div class="d-flex p-2"
								style="background-color: <?= $calendar->calendarBackgroundColor . '35'; ?>; border-radius: 0.25rem;">
								<div class="flex-shrink-0">
									<img style="border-radius: 0.25rem;" width="65px" height="65px" class="object-fit-cover"
										src="<?= $calendar->fileSrc ?? '/assets/images/calendar-image.png'; ?>"
										alt="<?= $calendar->fileName ?? 'Image not set calender image used'; ?>">
								</div>
								<div class="flex-grow-1 ms-3 d-flex flex-column">
									<a href="/calendar/<?= $calendar->calendarStart; ?>/<?= $calendar->calendarCipherId; ?>"
										class="mb-0 fw-semibold"><?= $calendar->calendarTitle; ?></a>
									<?php if (is_null($calendar->calendarEnd)): ?>
										<p class="mb-0"><?= $calendar->calendarStringStart; ?></p>
									<?php else: ?>
										<div class="d-flex flex-column">
											<p class="mb-0">
												<?= $calendar->calendarStringStart . ' ' . $calendar->calendarStringStartTime; ?>
											</p>
											<i class='bx bx-chevrons-right'></i>
											<p class="mb-0">
												<?= $calendar->calendarStringEnd . ' ' . $calendar->calendarStringEndTime; ?>
											</p>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card" style="height: 10.5rem;">
					<div class="card-header card-header-title">Author</div>
					<div class="card-body overflow-y-auto">
						<div class="d-flex">
							<div class="flex-shrink-0">
								<img style="border-radius: 0.25rem;" width="80px" height="80px" class="object-fit-cover"
									src="<?= $dataAuthor->fileSrc; ?>" alt="<?= $dataAuthor->fileName; ?>">
							</div>
							<div class="flex-grow-1 ms-2">
								<p class="mb-0 fw-bold"><?= $dataAuthor->name; ?></p>
								<p class="mb-0"><?= $dataAuthor->description; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card" style="height: 7rem;">
					<div class="card-header card-header-title">Tags</div>
					<div class="card-body overflow-y-auto">
						<?php if (empty($dataTags)): ?>
							<small>No data yet</small>
						<?php else: ?>
							<div class="d-flex gap-3">
								<?php foreach ($dataTags as $key => $dataTag): ?>
									<?= view_cell('\App\Cells\UiCell::tagBadge', ['name' => $dataTag->tagName]) ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- data_text -->
<?= $this->include('include/data_text'); ?>


<!-- data_medias -->
<div class="row my-3">
	<div class="col-12">
		<div class="card" style="max-height: 50rem;">
			<div class="card-header card-header-title">Media</div>
			<div class="card-body overflow-y-auto">
				<?php if (empty($dataMedias)): ?>
					<small>No data yet</small>
				<?php else: ?>
					<div class="row g-3">
						<?php foreach ($dataMedias as $key => $dataMedia): ?>
							<div class="col-lg-3 col-md-4 col-6">
								<div class="card shadow-none h-100 w-100">
									<?php if (str_starts_with($dataMedia->fileMimetype, 'image')): ?>
										<div class="w-100 h-100 position-relative">
											<img class="object-fit-cover" style="width: inherit; height: inherit;"
												role="button" data-bs-toggle="modal" data-bs-target="#viewModal"
												src="<?= $dataMedia->fileSrc; ?>" alt="<?= $dataMedia->fileName; ?>"
												data-src="<?= $dataMedia->fileSrc; ?>" data-name="<?= $dataMedia->fileName; ?>"
												data-mime="<?= $dataMedia->fileMimetype; ?>">
										</div>

										<div class="card-body px-0">
											<small class="card-text">
												<?= $dataMedia->fileName; ?>
											</small>
										</div>
									<?php elseif (str_starts_with($dataMedia->fileMimetype, 'video')): ?>
										<div class="w-100 h-100 position-relative">
											<video class="object-fit-cover" style="width: inherit; height: inherit;"
												role="button" data-bs-toggle="modal" data-bs-target="#viewModal"
												data-src="<?= $dataMedia->fileSrc; ?>" data-name="<?= $dataMedia->fileName; ?>"
												data-mime="<?= $dataMedia->fileMimetype; ?>">
												<source src="<?= $dataMedia->fileSrc; ?>" type="<?= $dataMedia->fileMimetype; ?>">
												<?= $dataMedia->fileName; ?>
											</video>
											<i class='bx bx-play-circle bx-lg position-absolute top-50 start-50 translate-middle white-color'
												style="pointer-occasions: none;"></i>
										</div>

										<div class="card-body px-0">
											<small class="card-text">
												<?= $dataMedia->fileName; ?>
											</small>
										</div>
									<?php elseif (str_starts_with($dataMedia->fileMimetype, 'audio')): ?>
										<audio class="card-img-top" data-bs-toggle="modal" data-bs-target="#viewModal"
											data-src="<?= $dataMedia->fileSrc; ?>" data-name="<?= $dataMedia->fileName; ?>"
											data-mime="<?= $dataMedia->fileMimetype; ?>" controls>
											<source src="<?= $dataMedia->fileSrc; ?>" type="<?= $dataMedia->fileMimetype; ?>">
											<?= $dataMedia->fileName; ?>
										</audio>
										<div class="card-body px-0">
											<small class="card-text">
												<?= $dataMedia->fileName; ?>
											</small>
										</div>
									<?php else: ?>
										<img class="image-fluid" src="/assets/images/file_mime_type_unknown.png"
											alt="<?= $dataMedia->fileName; ?>">
										<div class="card-body px-0">
											<small class="card-text">
												<?= $dataMedia->fileName; ?>
											</small>
										</div>
									<?php endif ?>

								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>


<!-- view_modal -->
<?= $this->include('include/view_modal'); ?>


<?= $this->endSection(); ?>