<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Contact',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Contact',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<!-- contact-section -->
<div class="mb-5">
	<div class="container">
		<div class="row row-gap-5">
			<div class="col-md-6 col-12">
				<h1>Are there any inquiries you would like to make?</h1>
				<div class="mt-5 d-flex flex-column row-gap-5">
					<div class="d-flex align-items-center">
						<div class="flex-shrink-0">
							<i class='bx bxs-phone-call bx-lg p-4 border-radius color-second-600'
								style="background-color: var(--color-first-100);"></i>
						</div>
						<div class="flex-grow-1 ms-3">
							<h5 class="card-title mb-2">Call</h5>
							<p class="card-text"><?= $information['mobile']; ?></p>
						</div>
					</div>

					<div class="d-flex align-items-center">
						<div class="flex-shrink-0">
							<i class='bx bxs-envelope bx-lg p-4 border-radius color-second-600' 
								style="background-color: var(--color-first-100);"></i>
						</div>
						<div class="flex-grow-1 ms-3">
							<h5 class="card-title mb-2">Mail</h5>
							<p class="card-text"><?= $information['email']; ?></p>
						</div>
					</div>
				</div>
				
			</div>

			<div class="col-md-6 col-12">
				<div class="card">
					<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Get in touch with us']); ?>
					<div class="card-body">
						<?= view_cell('\Cells\AlertCell::contact'); ?>
						<?php $validation = \Config\Services::validation(); ?>
						<form action="<?= '/contact'; ?>" method="POST">
							<div class="row row-cols-1">
								<div class="col mb-4">
									<input type="text" class="form-control" id="nameInput" placeholder="Name"
										name="name">
									<?php if ($validation->getError('name')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('name'); ?>
										</span>
									<?php endif; ?>
								</div>

								<div class="col mb-4">
									<input type="email" class="form-control" id="emailInput" placeholder="Email"
										name="email">
									<?php if ($validation->getError('email')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('email'); ?>
										</span>
									<?php endif; ?>
								</div>

								<div class="col mb-4">
									<input type="text" class="form-control" id="subjectInput" placeholder="Subject"
										name="subject">
									<?php if ($validation->getError('subject')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('subject'); ?>
										</span>
									<?php endif; ?>
								</div>

								<div class="col mb-4">
									<textarea class="form-control" name="message" id="exampleFormControlTextarea1"
										rows="5" placeholder="Message"></textarea>
									<?php if ($validation->getError('message')): ?>
										<span class="text-danger text-sm">
											<?= $error = $validation->getError('message'); ?>
										</span>
									<?php endif; ?>
								</div>

								<div class="col">
									<button type="submit" name="submit" class="btn primary-btn w-100">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>