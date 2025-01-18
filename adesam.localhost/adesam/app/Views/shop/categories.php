<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Categories',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/shop' => 'Shop'],
	'dataCarouselBreadCrumbActive' => 'Categories',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<div class="mb-5">
	<?php if (empty($datas)): ?>
		<div>No data yet</div>
	<?php else: ?>
		<div class="row row-cols-md-2 row-cols-lg-3 row-cols-1 row-gap-4">
			<?php foreach ($datas as $data): ?>
				<?php $dataImage = $data->image; ?>
				<div class="col">
					<div class="card">
						<a href="/shop/categories/<?= $data->slug; ?>">
							<img src="<?= $dataImage->fileSrc; ?>" class="card-img-top" alt="<?= $dataImage->fileName; ?>">
						</a>
						<div class="card-body px-0">
							<a href="/shop/categories/<?= $data->slug; ?>"
								class="card-title fs-5 fw-medium"><?= $data->name; ?></a>
							<p class="card-text"><?= $data->description; ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>






<?= $this->endSection(); ?>