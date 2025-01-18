<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>

<?php $dataCardHeader = [
	'detailsCoverImageSrc' => '/assets/images/background-image.jpg',
	'detailsCoverImageAlt' => 'Cover Image',
	'detailsAvatarImageSrc' => $dataImage->fileSrc ?? '/assets/images/avatar-contact.png',
	'detailsAvatarImageAlt' => $dataImage->fileName ?? 'Image not set avatar used',
	'name' => (is_null($data->nickname)) ? $data->firstName . ' ' . $data->lastName : $data->nickname,
	'updateHref' => '/contacts/' . $data->cipherId . '/update',
	'deleteHref' => '/contacts/' . $data->cipherId . '/delete',
	'buttons' => [
		'<a href="/calendar/create" class="btn primary-btn" data-bs-toggle="modal" data-bs-target="#addCalendarModal">New Calendar</a>',
	],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>


<div class="row g-3 my-3">
	<div class="col-lg-5 col-md-6 col-12">
		<?php $basicRow = [
			'rows' => [
				'Nickname' => $data->nickname,
				'First Name' => $data->firstName,
				'Last Name' => $data->lastName,
				'Mobile Number' => $data->mobile,
				'Email' => $data->email,
				'Date of birth' => $data->dob,
				'Description' => $data->description,
				'Gender' => \App\Enums\Gender::getValue($data->gender),
				'Type' => \App\Enums\ContactType::getValue($data->type),
				'Created' => $data->createdDateTime,
				'Last Modified' => $data->modifiedDateTime ?? 'Never Modified',
			],
			'height' => 31, // Add 1rem for gap space
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicRow); ?>
	</div>

	<div class="col-lg-7 col-md-6 col-12">
		<div class="row g-3">
			<div class="col-12">
				<div class="card" style="height: 23rem; min-height: 23rem;">
					<div class="card-header card-header-title">Calendars</div>
					<div class="card-body overflow-y-auto">
						<div class="d-flex flex-column row-gap-2">
							<?php if (empty($calendars)): ?>
								<p>No data yet</p>
							<?php else: ?>
								<?php foreach ($calendars as $key => $calendar): ?>
									<div class="d-flex p-2"
										style="background-color: <?= $calendar->calendarBackgroundColor . '35'; ?>; border-radius: 0.25rem;">
										<div class="flex-shrink-0">
											<img style="border-radius: 0.25rem;" width="65px" height="65px"
												class="object-fit-cover"
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
													<p class="mb-0"><?= $calendar->calendarStringStart . ' ' . $calendar->calendarStringStartTime; ?></p>
													<i class='bx bx-chevrons-right'></i>
													<p class="mb-0"><?= $calendar->calendarStringEnd . ' ' . $calendar->calendarStringEndTime; ?></p>
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

			<div class="col-12">
				<div class="card" style="height: 7rem; min-height: 7rem;">
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

<!-- data_address -->
<div class="row my-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header card-header-title">Address</div>
			<div class="card-body overflow-y-auto">
				<?php if (is_null($dataAddress)): ?>
					<p>No data yet</p>
				<?php else: ?>
					<div class="row gap-2">
						<?php if (!is_null($dataAddress->address)): ?>
							<div class="col-md-5 col-12">
								<div class="d-flex flex-column">
									<p class="mb-0 fs-8">Address</p>
									<h6 class="mb-0"><?= $dataAddress->address; ?></h6>
								</div>
							</div>
						<?php endif; ?>

						<?php if (!is_null($dataAddress->postalCode)): ?>
							<div class="col-md-3 col-sm-6 col-12">
								<div class="d-flex flex-column">
									<p class="mb-0 fs-8">Postal Code</p>
									<h6 class="mb-0"><?= $dataAddress->postalCode; ?></h6>
								</div>
							</div>
						<?php endif; ?>

						<?php if (!is_null($dataAddress->countryName)): ?>
							<div class="col-md-3 col-sm-6 col-12">
								<div class="d-flex flex-column">
									<p class="mb-0 fs-8">Country</p>
									<h6 class="mb-0"><?= $dataAddress->countryName; ?></h6>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</div>

<!-- data_additional_imformations -->
<?= view_cell(
	'\App\Cells\DetailsCell::additionalInformations',
	['dataAdditionalInformations' => $dataAdditionalInformations]
); ?>


<!-- Add Calendar modal -->
<div class="modal fade" id="addCalendarModal" tabindex="-1" aria-tagledby="addCalendarModalTag" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">New Calendar</div>
			</div>
			<div class="modal-body" id="addCalendarModalBodyDiv">
				<form method="POST" id="addCalendarModalForm" action="<?= '/calendar/create'; ?>"
					onSubmit="document.getElementById('submitDiscount').disabled=true;">
					<div class="mb-4">
						<input type="text" name="title" id="titleModalInput" class="form-control"
							placeholder="Enter Title" />
					</div>

					<div class="row row-cols-md-2 row-cols-1 mb-4">
						<div class="col">
							<select class="form-select" id="typeSelect" name="type" aria-label="Default select example">
								<option selected disabled>Select Type</option>
								<?php foreach ($calendarEnum as $key => $value): ?>
									<option value='<?= $key; ?>'>
										<?= $value; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col">
							<select class="form-select" id="recurringTypeSelect" name="recurringType"
								aria-label="Default select example">
								<option selected disabled>Select Recurring Type</option>
								<?php foreach ($calendarRecurringEnum as $key => $value): ?>
									<option value='<?= $key; ?>'>
										<?= $value; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>


					</div>

					<div class="row row-cols-md-2 row-cols-1 mb-4">
						<div class="col">
							<input type="text" name="startDateTime" id="startDateTimeInput"
								placeholder="Select Start Date Time" class="form-control" data-input>
						</div>

						<div class="col">
							<input type="text" name="endDateTime" id="endDateTimeInput"
								placeholder="Select End Date Time" class="form-control" data-input>
						</div>
					</div>

					<div class="mb-4">
						<textarea name="description" id="descriptionTextarea" class="form-control"
							placeholder="Enter Description" rows="3"></textarea>
					</div>

					<input type="hidden" name="additionalInformationsHidden" value="[]" />
					<input type="hidden" name="contactId" value="<?= $data->cipherId; ?>" />

					<!-- Submit button -->
					<button type="submit" name="submit" id="submitDiscount" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>





<?= $this->endSection(); ?>