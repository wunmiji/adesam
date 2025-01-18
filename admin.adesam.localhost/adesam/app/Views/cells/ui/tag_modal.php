<div class="modal fade" id="tagModal" tabindex="-1" aria-tagledby="tagModalTag" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<div class="card-header card-header-title">New Tag</div>
			</div>
			<div class="modal-body" id="tagModalBodyDiv">
				<form method="POST" id="tagModalForm" action="<?= $action; ?>"
					onSubmit="document.getElementById('submit').disabled=true;">
					<div class="mb-4">
						<input type="text" name="name" id="nameModalInput" class="form-control"
							placeholder="Enter Name" />
					</div>

					<!-- Submit button -->
					<button type="submit" name="submit" class="btn primary-btn">Create</button>
				</form>
			</div>
		</div>
	</div>
</div>