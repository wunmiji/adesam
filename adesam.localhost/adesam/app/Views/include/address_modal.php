<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<div class="card-header card-header-title" id="address_header_modal"></div>
			</div>
			<div class="modal-body" id="modalBodyDiv">
				<form method="POST" id="address_form_modal"
					onSubmit="document.getElementById('address_form_modal').disabled=true;">

					<div class="row row-cols-lg-2 row-cols-1 mb-4">
						<div class="col">
							<input type="text" name="first_name" id="firstNameInput" class="form-control"
								value="<?= set_value('first_name'); ?>" placeholder="First Name" />
						</div>

						<div class="col">
							<input type="text" name="last_name" id="lastNameInput" class="form-control"
								value="<?= set_value('last_name'); ?>" placeholder="Last Name" />
						</div>
					</div>

					<div class="mb-4">
						<select class="form-select" name="countries" id="country"
							data-countries="<?= esc(json_encode($countries)); ?>" aria-label="Default select example">
							<option selected disabled>Select Country</option>
						</select>
					</div>

					<div class="mb-4">
						<input type="text" name="address_1" id="addressInputOne" class="form-control"
							value="<?= set_value('address_1'); ?>" placeholder="Enter Address" />
					</div>

					<div class="mb-4">
						<input type="text" name="address_2" id="addressInputTwo" class="form-control"
							value="<?= set_value('address_2'); ?>" placeholder="Enter Apartment, suite, unit, etc" />
					</div>

					<div class="row mb-4">
						<div class="col-md-6 col-12">
							<input type="text" name="city" id="cityInput" class="form-control"
								value="<?= set_value('city'); ?>" placeholder="Enter City" />
						</div>

						<div class="col-md-6 col-12">
							<input type="text" name="postal_code" class="form-control" id="postalCodeInput"
								value="<?= set_value('postal_code'); ?>" placeholder="Enter Postal Code">
						</div>
					</div>

					<div class="mb-4">
						<select class="form-select" name="states" id="state" aria-label="Default select example">
							<option selected disabled>Select State / Province</option>
						</select>
					</div>

					<div class="mb-4">
						<input type="email" class="form-control" id="emailInput" placeholder="Enter Email" name="email">
					</div>

					<div class="mb-4">
						<input type="tel" name="mobile" id="mobileInput" class="form-control"
							value="<?= set_value('mobile'); ?>" placeholder="Enter Mobile Number" />
					</div>

					<div class="d-flex justify-content-center">
						<button type="submit" name="submit" class="btn primary-btn">Submit</button>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
