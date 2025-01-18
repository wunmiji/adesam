<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Search',
	'dataCarouselBreadCrumb' => ['/' => 'Home'],
	'dataCarouselBreadCrumbActive' => 'Search',
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>


<div class="mb-4">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 col-md-9 col-12">
				<div class="text-center">
					<?= view_cell('\App\Cells\MainCell::search', ['searchText' => $searchText ?? '', 'searchId' => 'searchTextTwo']); ?>
					<p class="mt-3"><?= $search; ?></p>
				</div>
			</div>
		</div>
	</div>
</div>


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