<?= $this->extend('layouts/default'); ?>

<?= $this->section('content'); ?>

<!-- header -->
<?php $titleHeader = [
	'title' => $title,
	'buttons' => []
];
?>
<?= view_cell('\App\Cells\UiCell::titleHeader', $titleHeader); ?>


<div class="row g-3 my-2">
	<div class="col">
		<div class="card" style="max-height: 70rem;">
			<div class="card-header d-flex justify-content-between">
				<div class="card-header-title">Explorer</div>
				<?php if (
					$dataFileManagerPrivateId != $dataPrivateId &&
					'Trash' != $dataPrivateId &&
					'Favourite' != $dataPrivateId
				): ?>
					<div class="d-flex column-gap-3">
						<a href="/file-manager/<?= $dataPrivateId; ?>/create-folder" title="Add Folder"
							class="d-flex color-third-500"><i class="bx bx-folder-plus bx-sm align-self-end"></i></a>
						<a href="/file-manager/<?= $dataPrivateId; ?>/create-file" title="Add File"
							class="d-flex color-third-500"><i class="bx bxs-file-plus bx-sm align-self-end"></i></a>
					</div>
				<?php endif; ?>

			</div>
			<div class="card-body overflow-y-auto">
				<div>
					<?php $breadCrumbLastElement = array_pop($dataBreadCrumbArray); ?>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<?php foreach ($dataBreadCrumbArray as $key => $data): ?>
								<li class="breadcrumb-item">
									<a class="py-1 px-2" style="background-color: rgba(185, 187, 189, 0.2);"
										href="/file-manager/<?= $key; ?>"><?= $data; ?></a>
								</li>
							<?php endforeach; ?>
							<li class="breadcrumb-item active" aria-current="page"><?= $breadCrumbLastElement; ?></li>
						</ol>
					</nav>
				</div>
				<div class="row">
					<div class="col-md-3 col-4">
						<div class="d-flex flex-column row-gap-4">
							<div>
								<p class="mb-0 font-monospace fs-8">P L A C E S</p>
								<div class="d-flex flex-column row-gap-3 mt-2">
									<a href="/file-manager/Favourite"
										class="d-flex align-items-center column-gap-2 fs-6 color-third-500">
										<i class='bx bxs-heart' style="font-size: 1.25rem;"></i>
										Favourite
									</a>
									<?php foreach ($places as $key => $data): ?>
										<a href="/file-manager/<?= $data->privateId; ?>"
											class="d-flex align-items-center column-gap-2 fs-6 color-third-500">
											<?php $fileManagerIcon = ''; ?>
											<?php if ($data->name == 'Home')
												$fileManagerIcon = 'bx-home'; ?>
											<?php if ($data->name == 'Documents')
												$fileManagerIcon = 'bx-file'; ?>
											<?php if ($data->name == 'Videos')
												$fileManagerIcon = 'bxs-videos'; ?>
											<?php if ($data->name == 'Pictures')
												$fileManagerIcon = 'bx-images'; ?>
											<?php if ($data->name == 'Shop')
												$fileManagerIcon = 'bx-store'; ?>
											<i class='bx <?= $fileManagerIcon; ?>' style="font-size: 1.25rem;"></i>
											<?= $data->name; ?>
										</a>
									<?php endforeach; ?>
									<a href="/file-manager/Trash"
										class="d-flex align-items-center column-gap-2 fs-6 color-third-500">
										<i class='bx bxs-trash' style="font-size: 1.25rem;"></i>
										Trash
									</a>
								</div>
							</div>

						</div>

					</div>
					<div class="col-md-9 col-8">
						<?php if ($dataFileManagerPrivateId == $dataPrivateId): ?>
							<table id="table" class="table table-hover">
								<thead>
									<tr>
										<th scope="col">Name</th>
										<th scope="col">Size</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($datas as $key => $data): ?>
										<tr>
											<td>
												<div class="d-flex align-items-center column-gap-2">
													<?php $fileManagerIcon = ''; ?>
													<?php if ($data->name == 'Home')
														$fileManagerIcon = 'bx-home'; ?>
													<?php if ($data->name == 'Documents')
														$fileManagerIcon = 'bx-file'; ?>
													<?php if ($data->name == 'Videos')
														$fileManagerIcon = 'bxs-videos'; ?>
													<?php if ($data->name == 'Pictures')
														$fileManagerIcon = 'bx-images'; ?>
													<?php if ($data->name == 'Shop')
														$fileManagerIcon = 'bx-store'; ?>
													<i class='bx <?= $fileManagerIcon; ?>' style="font-size: 1.25rem;"></i>
													<a class="" href="/file-manager/<?= $data->privateId ?>">
														<?= $data->name; ?>
													</a>
												</div>
											</td>
											<td scope="row">
												<?= esc($data->size); ?>
											</td>
											<td class="text-nowrap text-start">
												<div class="btn-group">
													<a role="button" data-bs-toggle="dropdown" aria-expanded="false">
														<i class='bx bx-dots-horizontal bx-sm'></i>
													</a>

													<ul class="dropdown-menu rounded-0">
														<li>
															<?php
															$parentPathValueArray = explode('/', esc($data->parentPath));
															array_shift($parentPathValueArray);
															$fileManagerValue = ucwords(str_replace("-", " ", array_shift($parentPathValueArray)));
															array_unshift($parentPathValueArray, $fileManagerValue);
															$parentPathValue = implode('/', $parentPathValueArray);
															?>
															<a class="dropdown-item" data-bs-toggle="modal"
																data-src="<?= esc($data->urlPath); ?>"
																data-name="<?= esc($data->name); ?>"
																data-description="<?= esc($data->description); ?>"
																data-mime="<?= esc($data->mimetype); ?>"
																data-size="<?= esc($data->size); ?>"
																data-parent-path="<?= $parentPathValue; ?>"
																data-is-directory="<?= esc($data->isDirectory); ?>"
																data-type="<?= \App\Enums\FileType::getValue(esc($data->type)); ?>"
																data-extension="<?= esc($data->extension); ?>"
																data-added="<?= esc($data->createdDateTime); ?>"
																data-modified="<?= esc($data->lastModified); ?>"
																data-bs-target="#infoModal">Info</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php else: ?>
							<div class="table-responsive">
								<table id="table" class="table table-hover">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Name</th>
											<th scope="col">Size</th>
											<?php if ($dataPrivateId != 'Trash'): ?>
												<th scope="col">Favourite</th>
											<?php endif; ?>
											<th scope="col">Actions</th>
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
													<td class="text-wrap">
														<div class="d-flex align-items-center column-gap-2">
															<?php if ($data->isDirectory): ?>
																<i class='bx bx-folder' style="font-size: 1.25rem;"></i>
																<a class="" href="/file-manager/<?= $data->privateId ?>">
																	<?= $data->name; ?>
																</a>
															<?php else: ?>
																<i class='bx bx-file' style="font-size: 1.25rem;"></i>
																<p class="mb-0"><?= $data->name; ?></p>
															<?php endif; ?>
														</div>
													</td>
													<td scope="row">
														<?= esc($data->size); ?>
													</td>
													<?php if ($dataPrivateId != 'Trash'): ?>
														<th scope="row">
															<a href="/file-manager/<?= $data->privateId; ?>/favourite">
																<?php if ($data->isFavourite): ?>
																	<i class='bx bxs-heart' style="font-size: 1.25rem;"></i>
																<?php else: ?>
																	<i class='bx bx-heart' style="font-size: 1.25rem;"></i>
																<?php endif; ?>
															</a>
														</th>
													<?php endif; ?>
													<td class="text-nowrap text-start">
														<div class="btn-group">
															<a role="button" data-bs-toggle="dropdown" aria-expanded="false">
																<i class='bx bx-dots-horizontal bx-sm'></i>
															</a>

															<ul class="dropdown-menu rounded-0">
																<?php if ($dataPrivateId == 'Trash'): ?>
																	<li>
																		<a class="dropdown-item"
																			href="/file-manager/<?= $data->privateId; ?>/restore">Restore</a>
																	</li>
																<?php endif; ?>
																<?php if ($data->isDirectory): ?>
																	<li>
																		<a class="dropdown-item"
																			href="/file-manager/<?= $data->privateId; ?>/update-folder">Update</a>
																	</li>
																<?php else: ?>
																	<?php if (
																		str_starts_with($data->mimetype, 'image') ||
																		str_starts_with($data->mimetype, 'video') ||
																		str_starts_with($data->mimetype, 'audio')
																	): ?>
																		<li>
																			<a class="dropdown-item" data-bs-toggle="modal"
																				data-bs-target="#viewModal"
																				data-src="<?= $data->urlPath; ?>"
																				data-name="<?= $data->name; ?>"
																				data-mime="<?= $data->mimetype; ?>">View</a>
																		</li>
																	<?php endif; ?>
																	<?php if ($dataPrivateId != 'Trash'): ?>
																		<li>
																			<?php $renameHref = '/file-manager/' . $data->privateId . '/rename'; ?>
																			<a class="dropdown-item" href="<?= $renameHref; ?>"
																				data-href="<?= $renameHref; ?>"
																				data-name="<?= esc($data->name); ?>" data-bs-toggle="modal"
																				data-bs-target="#renameModal">Rename</a>
																		</li>
																	<?php endif; ?>
																	<li>
																		<?php $downloadHref = '/file-manager/' . $data->privateId . '/download'; ?>
																		<a class="dropdown-item"
																			href="<?= $downloadHref; ?>">Download</a>
																	</li>
																<?php endif; ?>
																<li>
																	<?php
																	$parentPathValueArray = explode('/', esc($data->parentPath));
																	array_shift($parentPathValueArray);
																	$fileManagerValue = ucwords(str_replace("-", " ", array_shift($parentPathValueArray)));
																	array_unshift($parentPathValueArray, $fileManagerValue);
																	$parentPathValue = implode('/', $parentPathValueArray);
																	?>
																	<a class="dropdown-item" data-bs-toggle="modal"
																		data-src="<?= esc($data->urlPath); ?>"
																		data-name="<?= esc($data->name); ?>"
																		data-description="<?= esc($data->description); ?>"
																		data-mime="<?= esc($data->mimetype); ?>"
																		data-size="<?= esc($data->size); ?>"
																		data-parent-path="<?= $parentPathValue; ?>"
																		data-is-directory="<?= esc($data->isDirectory); ?>"
																		data-type="<?= \App\Enums\FileType::getValue(esc($data->type)); ?>"
																		data-extension="<?= esc($data->extension); ?>"
																		data-added="<?= esc($data->createdDateTime); ?>"
																		data-modified="<?= esc($data->lastModified); ?>"
																		data-bs-target="#infoModal">Info</a>
																</li>
																<?php if ($dataPrivateId == 'Trash'): ?>
																	<li>
																		<?php $deleteHref = '/file-manager/' . $data->privateId . '/delete/'; ?>
																		<a class="dropdown-item" href="<?= $deleteHref; ?>"
																			data-href="<?= $deleteHref; ?>" data-bs-toggle="modal"
																			data-bs-target="#deleteModal">Delete</a>
																	</li>
																<?php elseif ($dataPrivateId != 'Trash'): ?>
																	<li>
																		<a class="dropdown-item"
																			href="/file-manager/<?= $data->privateId; ?>/trash">Trash</a>
																	</li>
																<?php endif; ?>
															</ul>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>
									</tbody>
								</table>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- Rename modal -->
<div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-radius">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">Rename File</div>
			</div>
			<div class="modal-body" id="renameModalBodyDiv">
				<form method="POST" id="renameModalForm">
					<div class="mb-4">
						<input type="text" name="name" id="nameModalInput" class="form-control"
							placeholder="Enter Name" />
					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" class="btn primary-btn">Rename</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- view_modal -->
<?= $this->include('include/view_modal'); ?>

<!-- Info modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content border-radius">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">Info</div>
			</div>
			<div class="modal-body" id="infoModalBodyDiv"></div>
		</div>
	</div>
</div>

<!-- delete_modal -->
<?= $this->include('include/delete_modal'); ?>


<?= $this->endSection(); ?>