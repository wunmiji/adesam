<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a href="/occasions/create" class="btn primary-btn">New Occasion</a>',
		'<a href="/occasions/tags" class="btn primary-btn">Tags</a>',
		'<a href="/occasions/jobs" class="btn primary-btn">Jobs</a>'
	]
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
								<th scope="col">Title</th>
								<th scope="col">Status</th>
								<th scope="col">Summary</th>
								<th scope="col">Details</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($datas)): ?>
								<tr class="text-center">
									<td colspan="1000">No data yet</td>
								</tr>
							<?php else: ?>
								<?php $index = ($queryPage - 1) * $queryLimit; ?>
								<?php foreach ($datas as $key => $data): ?>
									<?php $dataImage = $data->image; ?>
									<?php $dataTags = $data->tags; ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<div class="d-flex">
												<div class="flex-shrink-0">
													<img width="70px" height="70px" class="object-fit-cover"
														src="<?= $dataImage->fileSrc; ?>" alt="<?= $dataImage->fileName; ?>">
												</div>
												<div class="flex-grow-1 ms-2 d-flex flex-column row-gap-1">
													<h6 class="mb-0"><?= $data->title; ?></h6>
													<div class="d-flex flex-wrap gap-1">
														<?php foreach ($dataTags as $key => $dataTag): ?>
															<?= view_cell('\App\Cells\UiCell::tagBadge', ['name' => $dataTag->tagName]) ?>
														<?php endforeach; ?>
													</div>
												</div>
											</div>
										</td>
										<td class="text-nowrap">
											<?= view_cell('\App\Cells\UiCell::occasionBadge', ['status' => $data->status]) ?>
										</td>
										<td class="text-wrap">
											<?= $data->summary; ?>
										</td>
										<td class="text-nowrap">
											<a href="occasions/<?= $data->cipherId; ?>" class="btn primary-btn">Details</a>
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