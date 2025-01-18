<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<?php $dataCardHeader = [
	'detailsCoverImageSrc' => $dataImage->fileSrc ?? '/assets/images/calendar-image.png',
	'detailsCoverImageAlt' => $dataImage->fileName ?? 'Image not set calendar Image used',
	'detailsAvatarIcon' => "<i class='bx bx-calendar-event bx-lg'></i>",
	'name' => $data->title,
	'updateHref' => '/calendar/' . $dataDate . '/' . $data->cipherId . '/update',
	'deleteHref' => '/calendar/' . $dataDate . '/' . $data->cipherId . '/delete',
	'buttons' => [],
] ?>
<?php if ($data->isLocked) {
	unset($dataCardHeader["updateHref"]);
	unset($dataCardHeader["deleteHref"]);
} ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>



<div class="row my-3">
	<div class="col">
		<div class="card">
			<div class="card-header card-header-title">Basic</div>
			<div class="card-body overflow-y-auto">
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Title:</h6>
					<div class="d-flex align-items-center column-gap-2">
						<p class="mb-0 flex-fill"><?= $data->title; ?></p>
						<i class='bx bxs-lock-alt'></i>
					</div>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Type:</h6>
					<p class="mb-0 flex-fill">
						<?= view_cell('\App\Cells\UiCell::calendarBadge', ['type' => $data->type]); ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Start Date:</h6>
					<p class="mb-0 flex-fill"><?= $data->start; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Start Time:</h6>
					<p class="mb-0 flex-fill"><?= \App\Libraries\DateLibrary::formatTime($data->startTime); ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">End Date:</h6>
					<p class="mb-0 flex-fill"><?= $data->end ?? $data->start; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">End Time:</h6>
					<p class="mb-0 flex-fill"><?= $data->endTime ?? \App\Libraries\DateLibrary::formatTime('23:59'); ?>
					</p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Description:</h6>
					<p class="mb-0 text-wrap flex-fill"><?= $data->description; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Created:</h6>
					<p class="mb-0 flex-fill"><?= $data->createdDateTime; ?></p>
				</div>
				<div class="d-flex column-gap-2 mb-2">
					<h6 class="mb-0 w-25 flex-shrink-0">Last Modified:</h6>
					<p class="mb-0 flex-fill"><?= $data->modifiedDateTime ?? 'Never Modified'; ?></p>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- data_additional_imformations -->
<?= view_cell(
	'\App\Cells\DetailsCell::additionalInformations',
	['dataAdditionalInformations' => $dataAdditionalInformations]
); ?>




<?= $this->endSection(); ?>