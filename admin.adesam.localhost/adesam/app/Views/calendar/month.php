<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a href="/calendar/create" class="btn primary-btn">New Calendar</a>',
		'<a href="/calendar/month" class="btn primary-btn">Month</a>'
	]
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="row g-3 my-2">
	<div class="col">
		<div class="card">
			<div class="card-body overflow-y-auto">
				<div id="calendar" data-timezone="<?= $timezone; ?>" data-first-day="<?= $firstDay; ?>"></div>
			</div>
		</div>
	</div>
</div>





<?= $this->endSection(); ?>