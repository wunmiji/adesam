<!-- data_additional_imformations -->
<div class="row my-3">
	<div class="col-12">
		<div class="card" style="max-height: 21rem;">
			<div class="card-header card-header-title">Addtional Informations</div>
			<div class="card-body overflow-y-auto">
				<?php if (empty($dataAdditionalInformations)): ?>
					<small>No data yet</small>
				<?php else: ?>
					<div class="d-flex gap-3">
						<table class="table table-borderless">
							<tbody>
								<?php foreach ($dataAdditionalInformations as $key => $dataAdditionalInformation): ?>
									<tr>
										<td class="fw-bold w-25"><?= $dataAdditionalInformation->field; ?></td>
										<td><?= $dataAdditionalInformation->label; ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>