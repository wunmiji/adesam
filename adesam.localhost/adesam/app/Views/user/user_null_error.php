<?= $this->extend('layouts/default_user'); ?>


<?= $this->section('content_user'); ?>

<section class="my-5">
	<div class="row justify-content-center">
		<div class="col-lg-7 col-md-8 col-sm-10 col-12">
			<div class="card">
				<img src="/assets/images/404.svg" class="card-img-top" alt="404 Error Page Image">
				<div class="card-body">
					<div class=" my-4 text-center">
						<h2>Oops! This order can’t be found</h2>
						<h5>Sorry, but the order you were trying to view does not exist.</h5>
						<a href="\user" class="btn fs-5 primary-btn mt-2">RETURN TO PROFILE</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>