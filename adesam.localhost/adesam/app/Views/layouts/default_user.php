<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Profile',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'User',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>


<div class="mb-5 row g-5">
	<div class="col-lg-3 col-md-4 col-12">
		<div class="card">
			<div class="card-body card-border">
				<div class="d-flex flex-column align-items-center mt-3 mb-4">
					<div class="p-1 mb-2 card-border" style="border-width: 1px;">
						<img class="object-fit-cover" width="80px" height="80px"
							src="<?= $dataImage->fileSrc ?? '/assets/images/avatar_user.png' ?>">
					</div>
					<h5 class="mb-0 text-center"><?= session()->get('userName'); ?></h5>
					<p class="mb-0 text-center color-first-100 text-break"><?= session()->get('userEmail'); ?></p>
				</div>
				<div class="d-flex flex-column row-gap-2">
					<a href="/user?tab=account" class="py-2 first-color-hover">Account</a>
					<a href="/user?tab=orders" class="py-2 first-color-hover">Orders</a>
					<a href="/user?tab=address" class="py-2 first-color-hover">Address</a>
					<a href="/user?tab=password" class="py-2 first-color-hover">Password</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-9 col-md-8 col-12">
		<?= $this->renderSection('content_user') ?>
	</div>
</div>


<?= $this->endSection(); ?>