<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<?php $dataCarousel = [
	'dataCarouselTitle' => 'Products',
	'dataCarouselBreadCrumb' => ['/' => 'Home', '/shop' => 'Shop', '/shop/categories' => 'Categories'],
	'dataCarouselBreadCrumbActive' => $category->name,
]; ?>
<?= view_cell('\App\Cells\MainCell::carousel', $dataCarousel); ?>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>

<div class="mb-5">
	<?php $categoryImage = $category->image; ?>
	<div class="row row-gap-3">
		<div class="col col-md-4 col-12">
			<img src="<?= $categoryImage->fileSrc; ?>" class="card-img-top border-radius" alt="<?= $categoryImage->fileName; ?>">
		</div>
		<div class="col col-md-8 col-12">
			<h5 class="card-title"><?= $category->name; ?></h5>
			<p class="card-text"><?= $category->description; ?></p>
		</div>
	</div>
</div>

<div class="mb-5">
	<div class="d-flex justify-content-between my-3">
		<button class="btn primary-btn" type="button" data-bs-toggle="offcanvas" id="filter-btn"
			data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas"
			data-query-string="<?= esc($queryString); ?>">
			<i class='bx bx-filter-alt'></i>
			Filters
		</button>
		<div class="d-flex align-items-center flex-wrap gap-3">
			<a href="/shop/categories">Categories</a>
			<a href="/shop/tags">Tags</a>
		</div>
	</div>

	<div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 gx-4 gy-5">
		<?php if (empty($datas)): ?>
			<div>No data yet</div>
		<?php else: ?>
			<?= view_cell('\Cells\MainCell::products', ['datas' => $datas]); ?>
		<?php endif; ?>
	</div>

	<div class="my-3">
		<?= $this->include('include/pagination'); ?>
	</div>
</div>



<!-- offcanvas -->
<?= $this->include('include/shop_offcanvas'); ?>



<?= $this->endSection(); ?>