<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?= $this->include('include/search_table_and_pagination_limit'); ?>

				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Number</th>
								<th scope="col">Name</th>
								<th scope="col">Status</th>
								<th scope="col">Date</th>
								<th scope="col">Price</th>
								<th scope="col">Details</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($data)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = ($queryPage - 1) * $queryLimit; ?>
								<?php foreach ($data as $key => $value): ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-nowrap">
											<?= '#' . $value->number ?>
										</td>
										<td class="text-wrap">
											<?= $value->userName; ?>
										</td>
										<td class="text-nowrap">
											<?= view_cell('\App\Cells\UiCell::orderBadge', ['status' => $value->status]) ?>
										</td>
										<td class="text-nowrap">
											<?= $value->date ?>
										</td>
										<td class="text-nowrap color-first-100">
											<?= $value->stringTotal; ?>
										</td>
										<td class="text-nowrap">
											<a href="/orders/<?= $value->cipherId; ?>" class="btn primary-btn">Details</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>

				<?= $this->include('include/pagination'); ?>
			</div>
		</div>
	</div>
</div>



<?= $this->endSection(); ?>