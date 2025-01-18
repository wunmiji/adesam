<!doctype html>
<html lang="en" data-base-url="<?= base_url(); ?>" data-user="<?= var_export(session()->has('userId')); ?>"
	data-user-id="<?= session()->get('userId'); ?>">

<head>
	<!-- meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- meta-tags -->
	<?= $metatags ?? ''; ?>
	<meta name=”robots” content="index, follow">

	<!-- schema -->
	<?= $schema ?? ''; ?>

	<!-- favicons -->
	<link rel="touch-icon" sizes="180x180" href="/assets/favicon/touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="/assets/favicon/site.webmanifest">

	<!-- fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">

	<!-- icons -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

	<!-- css -->
	<link href="/assets/css/library/bootstrap.min.css" rel="stylesheet">

	<!-- css_library through controller -->
	<?= $css_library ?? ''; ?>


	<!-- custom css -->
	<link rel="stylesheet" href="/assets/css/custom/animaview.css" />
	<link href="<?= '/assets/css/custom/styles.css'; ?>" rel="stylesheet" />

	<!-- other css_custom through controller -->
	<?= $css_custom ?? ''; ?>

</head>

<body>


	<!-- header -->
	<header class="">
		<nav class="navbar navbar-expand-lg fixed-top navbar-font navbar-custom">
			<div class="container">
				<a class="navbar-brand py-0" href="/">
					<img src="<?= '/assets/brand/logo.svg'; ?>" alt="Logo" width="150">
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
					aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav ms-auto">
						<li class="nav-item mx-2">
							<a class="nav-link" aria-current="page" href="/">Home</a>
						</li>
						<li class="nav-item mx-2">
							<a class="nav-link" href="/about">About</a>
						</li>
						<li class="nav-item mx-2">
							<a class="nav-link" href="/occasions">Occasions</a>
						</li>
						<li class="nav-item mx-2">
							<a class="nav-link" href="/contact">Contact</a>
						</li>
						<li class="nav-item mx-2">
							<a class="nav-link" href="/shop">Shop</a>
						</li>
					</ul>

					<ul class="nav align-items-center justify-content-center">
						<li class="nav-item">
							<a class="nav-link px-2 d-flex align-items-center" role="button" data-bs-toggle="modal"
								data-bs-target="#searchModal">
								<i class='bx bx-search' style="font-size: 1.25rem;"></i>
							</a>
						</li>
						<li class="nav-item">
							<?php if (session()->has('userId')): ?>
								<div class="btn-group">
									<a class="nav-link px-2 d-flex align-items-center" role="button"
										data-bs-toggle="dropdown" data-bs-display="static" data-bs-auto-close="outside"
										aria-expanded="false">
										<i class='bx bx-user-circle color-first-100' style="font-size: 1.25rem;"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-end border-radius">
										<li class="">
											<div class="dropdown-header">
												<div class="d-flex">
													<img src="<?= session()->get('userImage'); ?>" width="40px"
														height="40px" class="border-radius">
													<div class="ms-2">
														<h6 class="mb-0 text-uppercase"><?= session()->get('userName'); ?>
														</h6>
														<p class="mb-0"><?= session()->get('userEmail'); ?></p>
													</div>
												</div>
											</div>
										</li>
										<li class="">
											<a class="dropdown-item" href="/user">
												<i class='bx bx-user fs-5 me-2'></i>
												<span>My Profile</span>
											</a>
										</li>
										<li class="">
											<a href="/shop/cart" class="dropdown-item justify-content-between column-gap-5">
												<div class="d-flex align-items-center">
													<i class='bx bx-shopping-bag fs-5 me-2'></i>
													<span>Cart</span>
												</div>
												<span class="badge badge-label" id="totalCart"></span>
											</a>
										</li>
										<li class="">
											<a class="dropdown-item" href="/shop/checkout">
												<i class='bx bx-cart fs-5 me-2'></i>
												<span>Checkout</span>
											</a>
										</li>
										<li>
											<hr class="dropdown-divider">
										</li>
										<li class="">
											<div class="dropdown-item justify-content-between column-gap-5">
												<div class="d-flex align-items-center">
													<i class='bx bx-bulb fs-5 me-2'></i>
													<span>Dark Mode</span>
												</div>
												<i class='bx bxs-moon' onclick="dataBsTheme(this)"
													style="cursor: pointer;"></i>
											</div>
										</li>
										<li class="">
											<a class="dropdown-item" href="/logout" id="logout">
												<i class='bx bx-log-out fs-5 me-2'></i>
												<span>Logout</span>
											</a>
										</li>
									</ul>
								</div>
							<?php else: ?>
								<div class="btn-group">
									<a class="nav-link px-2" role="button" data-bs-toggle="dropdown"
										data-bs-display="static" data-bs-auto-close="outside" aria-expanded="false">
										<i class='bx bx-user' style="font-size: 1.25rem;"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-end border-radius">
										<li class="">
											<a href="/shop/cart" class="dropdown-item justify-content-between column-gap-5">
												<div class="d-flex align-items-center">
													<i class='bx bx-shopping-bag fs-5 me-2'></i>
													<span>Cart</span>
												</div>
												<span class="badge badge-label" id="totalCart"></span>
											</a>
										</li>
										<li class="">
											<div class="dropdown-item justify-content-between column-gap-5">
												<div class="d-flex align-items-center">
													<i class='bx bx-bulb fs-5 me-2'></i>
													<span>Dark Mode</span>
												</div>
												<i class='bx bxs-moon' onclick="dataBsTheme(this)"
													style="cursor: pointer;"></i>
											</div>
										</li>
										<li class="">
											<a class="dropdown-item" href="/login">
												<i class='bx bx-user fs-5 me-2'></i>
												<span>Login</span>
											</a>
										</li>
									</ul>
								</div>
							<?php endif; ?>
						</li>
					</ul>
				</div>

			</div>
		</nav>

		<!-- Modal -->
		<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen">
				<div class="modal-content" style="background-color: rgba(var(--color-third-500), 0.3);">
					<div class="modal-header border-0 d-flex justify-content-end">
						<div data-bs-dismiss="modal" aria-label="Close">
							<i class="bx bx-x bx-lg color-second-600" role="button"></i>
						</div>
					</div>
					<div class="modal-body">
						<div class="container h-100">
							<div class="row h-100 justify-content-center align-items-center">
								<div class="col-lg-6 col-md-9 col-12">
									<?= view_cell('\App\Cells\MainCell::search', ['searchText' => $searchText ?? '', 'searchId' => 'searchTextTwo']); ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</header>