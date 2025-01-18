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
	'detailsCoverImageSrc' => '/assets/images/background-image.jpg',
	'detailsCoverImageAlt' => 'Cover Image',
	'detailsAvatarImageSrc' => $dataImage->fileSrc ?? '/assets/images/avatar-family.png',
	'detailsAvatarImageAlt' => $dataImage->fileName ?? 'Image not set avatar used',
	'detailsAvatarIcon' => "<i class='bx bx-group bx-lg'></i>",
	'name' => $data->name,
	'updateHref' => '/family/' . $data->cipherId . '/update',
	'buttons' => [
		'<a href="/family/' . $data->cipherId . '/update_password" class="btn primary-btn">Update Password</a>',
		'<a href="/calendar/create" class="btn primary-btn" data-bs-toggle="modal" data-bs-target="#addCalendarModal">New Calendar</a>',
	],
] ?>
<?= view_cell('\App\Cells\DetailsCell::detailsCardHeader', $dataCardHeader); ?>

<div class="row g-3 my-3">
	<div class="col-md-6 col-12">
		<?php $basicTable = [
			'rows' => [
				'First Name' => $data->firstName,
				'Middle Name' => $data->middleName,
				'Last Name' => $data->lastName,
				'Role' => $data->role,
				'Gender' => \App\Enums\Gender::getValue($data->gender),
				'Date of Birth' => \App\Libraries\DateLibrary::getDate($data->dob),
				'Description' => $data->description,
				'Last Modified' => $data->modifiedDateTime,
			],
			'height' => 31,
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicTable); ?>
	</div>

	<div class="col-md-6 col-12">
		<div class="row g-3">
			<div class="col-12">
				<div class="card" style="height: 31rem;">
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
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row g-3">
	<div class="col-md-6 col-12">
		<?php $basicTable = [
			'title_basicDl' => 'Contact',
			'rows' => [
				'Email:' => $data->email,
				'Mobile:' => $data->mobile,
				'Telephone:' => $data->telephone
			],
			'height' => 15,
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicTable); ?>
	</div>

	<div class="col-md-6 col-12">
		<?php $basicTable = [
			'title_basicDl' => 'Social Media',
			'rows' => [
				'Facebook' => (is_null($dataSocialMedia)) ? "<i class='bx bxl-facebook-circle bx-sm me-2'></i>" : "<div class='d-flex justify-content-start'>
											<i class='bx bxl-facebook-circle bx-sm me-2'></i>
											<a href='$dataSocialMedia->facebook'>$dataSocialMedia->facebook</a>
										</div>",
				'Instagram' => (is_null($dataSocialMedia)) ? "<i class='bx bxl-instagram-alt bx-sm me-2'></i>" : "<div class='d-flex justify-content-start'>
											<i class='bx bxl-instagram-alt bx-sm me-2'></i>
											<a href='$dataSocialMedia->instagram'>$dataSocialMedia->instagram</a>
										</div>",
				'Linkedin' => (is_null($dataSocialMedia)) ? "<i class='bx bxl-linkedin-square bx-sm me-2'></i>" : "<div class='d-flex justify-content-start'>
											<i class='bx bxl-linkedin-square bx-sm me-2'></i>
											<a href='$dataSocialMedia->linkedin'>$dataSocialMedia->linkedin</a>
										</div>",
				'Twitter' => (is_null($dataSocialMedia)) ? "<i class='bx bxl-twitter bx-sm me-2'></i>" : "<div class='d-flex justify-content-start'>
											<i class='bx bxl-twitter bx-sm me-2'></i>
											<a href='$dataSocialMedia->twitter'>$dataSocialMedia->twitter</a>
										</div>",
				'Youtube' => (is_null($dataSocialMedia)) ? "<i class='bx bxl-youtube bx-sm me-2'></i>" : "<div class='d-flex justify-content-start'>
											<i class='bx bxl-youtube bx-sm me-2'></i>
											<a href='$dataSocialMedia->youtube'>$dataSocialMedia->youtube</a>
										</div>",
			],
			'height' => 15,
		] ?>
		<?= view_cell('\App\Cells\DetailsCell::basicDl', $basicTable); ?>
	</div>
</div>



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
					<input type="hidden" name="familyId" value="<?= $data->cipherId; ?>" />

					<!-- Submit button -->
					<button type="submit" name="submit" id="submitDiscount" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>