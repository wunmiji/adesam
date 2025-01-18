<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>



<!-- settings -->
<div class="row my-3">
	<div class="col-12">
		<div class="card">
			<div class="card-header card-header-title"><?= $title; ?></div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-2 col-12">
						<div class="d-flex flex-column row-gap-3">
							<a class="nav-link" href="/settings?tab=general">General</a>
							<a class="nav-link" href="/settings?tab=contact">Contact</a>
							<a class="nav-link" href="/settings?tab=shop">Shop</a>
							<a class="nav-link" href="/settings?tab=calendar">Calendar</a>
						</div>
					</div>
					<div class="col-md-10 col-12">
						<?= $this->renderSection('settings_content') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>