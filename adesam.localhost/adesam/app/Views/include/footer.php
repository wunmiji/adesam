<!-- footer -->
<footer class="pt-5">
	<div class="container">
		<div class="row justify-content-center py-5">
			<div class="col-sm-7 col-10 text-center">
				<div class="mb-4">
					<div>
						<img src="<?= '/assets/brand/logo.svg'; ?>" alt="Logo" width="190">
					</div>
				</div>
				<div class=" text-center">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, quis nostrud
						exercitation ullamco laboris nisi ut aliquip
						ex ea commodo consequat..</p>
					<ul class="nav justify-content-center column-gap-4">
						<li class="nav-item"><a href="/" class="nav-link px-0">Home</a></li>
						<li class="nav-item"><a href="/about" class="nav-link px-0">About</a></li>
						<li class="nav-item"><a href="/occasions" class="nav-link px-0">Occasions</a></li>
						<li class="nav-item"><a href="/contact" class="nav-link px-0">Contact</a></li>
						<li class="nav-item"><a href="/shop" class="nav-link px-0">Shop</a></li>
					</ul>
					<ul class="nav list-unstyled justify-content-center mx-0 px-0 pt-3">
						<?php if ($information['facebook']): ?>
							<li class="ms-3">
								<a class="text-body-secondary" href="<?= $information['facebook']; ?>">
									<i class='bx bxl-facebook-circle bx-sm'></i>
								</a>
							</li>
						<?php endif; ?>
						<?php if ($information['instagram']): ?>
							<li class="ms-3">
								<a class="text-body-secondary" href="<?= $information['instagram']; ?>">
									<i class='bx bxl-instagram-alt bx-sm'></i>
								</a>
							</li>
						<?php endif; ?>
						<?php if ($information['linkedIn']): ?>
							<li class="ms-3">
								<a class="text-body-secondary" href="<?= $information['linkedIn']; ?>">
									<i class='bx bxl-linkedin-square bx-sm'></i>
								</a>
							</li>
						<?php endif; ?>
						<?php if ($information['twitter']): ?>
							<li class="ms-3">
								<a class="text-body-secondary" href="<?= $information['twitter']; ?>">
									<i class='bx bxl-twitter bx-sm'></i>
								</a>
							</li>
						<?php endif; ?>
						<?php if ($information['youtube']): ?>
							<li class="ms-3">
								<a class="text-body-secondary" href="<?= $information['youtube']; ?>">
									<i class='bx bxl-youtube bx-sm'></i>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div>
		<div class="container pt-4">
			<hr class="my-0">
			<div class="d-flex justify-content-between py-3">
				<ul class="nav column-gap-3">
					<li class="nav-item"><a href="/privacy" class="nav-link px-0">Privacy</a></li>
					<li class="nav-item"><a href="/terms" class="nav-link px-0">Terms</a></li>
				</ul>
				<div class="d-flex align-items-center">
					<?php $founded = $information['founded']; ?>
					<?php $footerCopyrightYear = ($founded != date('Y')) ? ($founded . '-' . date('Y')) : $founded; ?>
					<span>Adesam.com © <?= $footerCopyrightYear; ?>.</span>
					<a href="<?= $information['developer-href']; ?>"
						class="mx-2"><?= $information['developer-name']; ?></a>
					<span>All right reserved.</span>
				</div>
			</div>
		</div>

	</div>
</footer>



<!-- js -->
<script src="/assets/js/library/bootstrap.bundle.js"></script>
<script src="/assets/js/library/jquery-3.7.1.min.js"></script>

<!-- js_library through controller -->
<?= $js_library ?? ''; ?>

<!-- custom js -->
<script src="/assets/js/custom/script.js"></script>

<!-- other js_customs  -->
<?= $js_custom ?? ''; ?>

</body>

</html>