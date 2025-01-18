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
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Description</th>
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
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<div class="d-flex">
												<div class="flex-shrink-0">
													<img width="50px" height="50px" class="object-fit-cover"
														src="<?= $dataImage->fileSrc ?? '/assets/images/avatar-user.png'; ?>" alt="<?= $dataImage->fileName ?? 'Image not set avatar used'; ?>">
												</div>
												<div class="flex-grow-1 ms-2 d-flex flex-column">
													<p class="mb-0"><?= $data->name; ?></p>
												</div>
											</div>
										</td>
										<td class="text-nowrap">
											<?= $data->email; ?>
										</td>
										<td class="text-wrap">
											<?= $data->description; ?>
										</td>
										<td class="text-nowrap">
											<a href="users/<?= $data->cipherId; ?>" class="btn primary-btn">Details</a>
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