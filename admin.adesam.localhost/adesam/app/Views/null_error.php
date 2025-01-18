<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>

<section class="my-5">
	<div class="row">
		<?= view_cell('\App\Cells\ErrorCell::error'); ?>
	</div>
</section>


<?= $this->endSection(); ?>