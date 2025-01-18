<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Occasions',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/occasions' => 'Ocassions', '/occasions/tags' => 'Tags'],
	'dataCarouselBreadCrumbActive' => $tag->name,
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>


<div class="mb-5">
	<div>
		<div id="alertDiv"></div>

		<?php if (empty($datas)): ?>
			<?= $this->include('include/empty_data'); ?>
		<?php else: ?>
			<div class="row justify-content-center">
				<div id="dataDiv" class="col-12 d-flex flex-column row-gap-5">
					<?= $this->include('include/load_occasions'); ?>
				</div>
			</div>
		<?php endif; ?>

		<div id="loadMoreDiv"></div>
	</div>

	<?= $this->include('include/load_more'); ?>
</div>



<?= $this->endSection(); ?>