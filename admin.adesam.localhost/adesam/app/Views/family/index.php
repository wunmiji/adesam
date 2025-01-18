<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a href="/family/create" class="btn primary-btn">New Member</a>'
	]
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="pt-4 row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive scrollbar">
					<table id="table" class="table table-hover">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Name</th>
								<th scope="col">Role</th>
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
								<?php $index = 0; ?>
								<?php foreach ($datas as $key => $data): ?>
									<?php $dataImage = $data->image; ?>
									<?php $index++; ?>
									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-nowrap">
											<div class="d-flex">
												<div class="flex-shrink-0">
													<img width="50px" height="50px" class="object-fit-cover"
														src="<?= $dataImage->fileSrc ?? '/assets/images/avatar-family.png'; ?>"
														alt="<?= $dataImage->fileName ?? 'Image not set avatar used'; ?>">
												</div>
												<div class="flex-grow-1 ms-2">
													<h6 class="mb-0"><?= $data->name; ?></h6>
												</div>
											</div>
										</td>
										<td class="text-nowrap">
											<?= $data->role; ?>
										</td>
										<td class="text-wrap">
											<?= $data->description; ?>
										</td>
										<td class="text-nowrap">
											<a href="family/<?= $data->cipherId; ?>" class="btn primary-btn">Details</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>


			</div>
		</div>
	</div>
</div>


<?= $this->endSection(); ?>