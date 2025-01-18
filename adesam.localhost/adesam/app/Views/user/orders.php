<?= $this->extend('layouts/default_user'); ?>


<!-- sections -->
<?= $this->section('content_user'); ?>



<section>
	<div class="mb-4">
		<?= view_cell('\Cells\MainCell::divTitle', ['title' => 'Orders']); ?>
	</div>
	<div class="table-responsive scrollbar">
		<table id="table" class="table table-hover">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Order</th>
					<th scope="col">Date</th>
					<th scope="col">Status</th>
					<th scope="col">Total</th>
					<th scope="col">View</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($datas)): ?>
					<tr class="text-center">
						<td colspan="1000">No data yet</td>
					</tr>
				<?php else: ?>
					<?php $index = 0; ?>
					<?php foreach ($datas as $key => $data): ?>
						<?php $index++; ?>
						<tr>
							<th scope="row">
								<?= $index; ?>
							</th>
							<td class="pe-4 text-nowrap fw-medium">
								<?= '#' . $data->number; ?>
							</td>
							<td class="pe-4 text-nowrap">
								<?= $data->date; ?>
							</td>
							<td class="pe-4 text-nowrap">
								<?= view_cell('\Cells\MainCell::orderBadge', ['status' => $data->status]); ?>
							</td>
							<td class="pe-4 text-nowrap">
								<?= $data->stringTotal; ?>
							</td>
							<td class="pe-4 text-nowrap">
								<a href="/user?tab=orders&view=<?= $data->number; ?>" class="btn primary-btn">View</a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</section>


<?= $this->endSection(); ?>