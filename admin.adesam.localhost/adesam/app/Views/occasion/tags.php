<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a class="btn primary-btn" data-bs-toggle="modal" data-bs-target="#tagModal">New Tag</a>'
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
								<th scope="col">Occasions</th>
								<th scope="col">Action</th>
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
									<?php $dataOccasions = $data->occasions; ?>
									<?php $index++; ?>

									<tr>
										<th scope="row">
											<?= $index; ?>
										</th>
										<td class="text-wrap">
											<?= $data->name; ?>
										</td>
										<td class="text-wrap">
											<div class="d-flex flex-wrap column-gap-3 row-gap-2">
												<?php foreach ($dataOccasions as $dataOccasion): ?>
													<div class="d-flex">
														<div class="flex-shrink-0">
															<img width="27px" height="27px" class="object-fit-cover"
																src="<?= $dataOccasion->fileSrc ?? '/assets/images/avatar-contact.png'; ?>"
																alt="<?= $dataOccasion->fileName ?? 'Image not set avatar used'; ?>">
														</div>
														<div class="flex-grow-1 ms-1">
															<a href="<?= $dataOccasion->occasionCipherId; ?>"
																class="mb-0"><?= $dataOccasion->title; ?></a>
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										</td>
										<td class="text-nowrap" style="font-size: 1.2rem;">
											<div class="d-flex column-gap-2">
												<a data-name="<?= esc($data->name); ?>"
													data-count="<?= esc(count($dataOccasions)); ?>"
													data-created="<?= esc($data->createdDateTime); ?>" data-bs-toggle="modal"
													data-bs-target="#tagInfoModal">
													<i class='bx bx-info-circle'></i>
												</a>

												<?php $deleteHref = '/occasions/tags/' . $data->cipherId . '/delete'; ?>
												<a href="<?= $deleteHref; ?>" data-href="<?= $deleteHref; ?>"
													data-bs-toggle="modal" data-bs-target="#deleteModal">
													<i class='bx bx-trash-alt'></i>
												</a>
											</div>
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



<!-- new_tag_modal -->
<?= view_cell('\App\Cells\UiCell::tagModal', ['action' => '/occasions/tags/create']); ?>

<!-- tag_info modal -->
<?= $this->include('include/tag_info'); ?>

<!-- delete_modal -->
<?= $this->include('include/delete_modal'); ?>


<?= $this->endSection(); ?>