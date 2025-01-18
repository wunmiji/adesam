<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'About',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'About',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>



<!-- about-section -->
<div class="mb-5">
	<div class="d-flex flex-column row-gap-5">
		<div>
			<h5 class="card-title mb-2">History</h5>
			<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
				eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
				nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
				aute
				irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
				pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
				deserunt mollit anim id est laborum.</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Lifestyle</h5>
			<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
				eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
				nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
				aute
				irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
				pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
				deserunt mollit anim id est laborum.</p>
		</div>

		<div>
			<h5 class="card-title mb-2">Religion</h5>
			<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
				eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
				nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis
				aute
				irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
				pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
				deserunt mollit anim id est laborum.</p>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>