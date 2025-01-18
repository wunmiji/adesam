<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Error Page',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => '404 Not Found',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<section class="mb-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 col-md-8 col-sm-10 col-12">
				<div class="card">
					<img src="/assets/images/404.svg" class="card-img-top" alt="404 Error Page Image">
					<div class="card-body">
						<div class=" my-4 text-center">
							<h2>Oops! This page can’t be found</h2>
							<h5>Sorry, but the page you were trying to view does not exist.</h5>
							<a href="\" class="btn fs-5 primary-btn mt-2">RETURN TO HOME</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>