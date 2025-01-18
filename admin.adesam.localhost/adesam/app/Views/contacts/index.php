<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<?php $titleHeader = [
	'title' => $title,
	'buttons' => [
		'<a href="/contacts/create" class="btn primary-btn">New Contact</a>',
		'<a href="/contacts/tags" class="btn primary-btn">Tags</a>'
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
								<th scope="col">Name</th>
								<th scope="col">Mobile Number</th>
								<th scope="col">Email</th>
								<th scope="col">Type</th>
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
													<img width="50px" height="50px" class="object-fit-cover"
														src="<?= $dataImage->fileSrc ?? '/assets/images/avatar-contact.png'; ?>"
														alt="<?= $dataImage->fileName ?? 'Image not set avatar used'; ?>">
												</div>
												<div class="flex-grow-1 ms-2 d-flex flex-column row-gap-1">
													<h6 class="mb-0"><?= $data->nickname; ?></h6>
													<div class="d-flex flex-wrap gap-1">
														<?php foreach ($dataTags as $key => $dataTag): ?>
															<?= view_cell('\App\Cells\UiCell::tagBadge', ['name' => $dataTag->tagName]) ?>
														<?php endforeach; ?>
													</div>
												</div>
											</div>
										</td>
										<td class="text-nowrap">
											<?= $data->mobile; ?>
										</td>
										<td class="text-nowrap">
											<?= $data->email; ?>
										</td>
										<td class="text-nowrap">
											<?= $data->type; ?>
										</td>
										<td class="text-nowrap">
											<a href="contacts/<?= $data->cipherId; ?>" class="btn primary-btn">Details</a>
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