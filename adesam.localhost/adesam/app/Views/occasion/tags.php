<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Tags',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/occasions' => 'Occasions'],
	'dataCarouselBreadCrumbActive' => 'Tags',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<div class="mb-5">
	<?php if (empty($datas)): ?>
		<div>No data yet</div>
	<?php else: ?>
		<div class="d-flex flex-wrap gap-4">
			<?php foreach ($datas as $data): ?>
				<a href="/occasions/tags/<?= $data->slug; ?>" class="btn primary-outline-btn"><?= $data->name; ?></a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>






<?= $this->endSection(); ?>