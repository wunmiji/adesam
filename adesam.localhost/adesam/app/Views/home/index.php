<?= $this->extend('layouts/default'); ?>



<!-- corousel-section -->
<?= $this->section('corousel'); ?>

<!-- Swiper -->
<div class="swiper home-swiper">
	<div class="swiper-wrapper">
		<div class="swiper-slide">
			<div class="position-relative" style="background: var(--color-third-100);">
				<img class="img-fluid" style="opacity: 0.7" src="/assets/images/background-image-1.jpg"
					alt="Slide background image">
				<div class="position-absolute  text-center"
					style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
					<h1 class="display-1 color-second-600">Adesam is not an important thing, it's everything</h1>
					<span class="color-second-600">— Princess Diana</span>
				</div>
			</div>
		</div>
		<div class="swiper-slide">
			<div class="position-relative" style="background: var(--color-third-100);">
				<img class="img-fluid" style="opacity: 0.7" src="/assets/images/background-image-1.jpg"
					alt="Slide background image">
				<div class="position-absolute  text-center"
					style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
					<h1 class="display-1 color-second-600">In time of test, family is best.</h1>
					<span class="color-second-600">— Burmese Proverb</span>
				</div>
			</div>
		</div>
		<div class="swiper-slide">
			<div class="position-relative" style="background: var(--color-third-100);">
				<img class="img-fluid" style="opacity: 0.7" src="/assets/images/background-image-3.jpg"
					alt="Slide background image">
				<div class="position-absolute  text-center"
					style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
					<h1 class="display-1 color-second-600">We are Celestial</h1>
					
				</div>
			</div>
		</div>
	</div>
	<div class="swiper-pagination"></div>
</div>

<?= $this->endSection(); ?>



<!-- sections -->
<?= $this->section('content'); ?>


<div class="mb-5">
	<div class="text-center mb-4">
		<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Latest Occasion']); ?>
	</div>
	<div class="d-flex flex-column row-gap-5">
		<?= $this->include('include/load_occasions'); ?>
	</div>
</div>


<?= $this->endSection(); ?>