<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between">
	<div class="fw-bold fs-5 gray-color">
		<?= $title; ?>
	</div>
</div>

<section class="my-5">
	<div class="row">
		<div class="col-md-5 col-sm-10 col-12">
		<i class='bx bxs-lock-alt bx-lg'></i>
		<h1>Locked Calendar cannot be <?= $type; ?></h1>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>