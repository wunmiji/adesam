<!doctype html>
<html lang="en" data-base-url="<?= base_url(); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, noodp, noarchive, noimageindex" />
    <title>
        <?= $title . ' - DanellaTech'; ?>
    </title>

    <!-- favicons -->
    <?= $this->include('include/favicons'); ?>

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

    <!-- other css through controller -->
    <?= $css_files ?? ''; ?>

    <!-- Custom styles -->
    <link href="/assets/css/custom/styles.css" rel="stylesheet" />

    <!-- other css_custom through controller -->
    <?= $css_custom ?? ''; ?>
</head>

<body>
    <div class="d-flex h-100 w-100 color-second-500-bg" id="wrapper">
        <aside class="d-flex flex-column">
            <div class="app-header d-flex align-items-center">
                <a href="/" class="px-4">
                    <img src="<?= '/assets/brand/logo.svg'; ?>" alt="">
                </a>
            </div>

            <div class="overflow-y-auto h-100 pt-3">
                <div class="d-flex flex-column">
                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/dashboard">
                            <i class='bx bx-home'></i>
                            <span>Dashboard</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/family">
                            <i class='bx bx-group'></i>
                            <span>Family</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/contacts">
                            <i class='bx bxs-contact'></i>
                            <span>Contacts</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/calendar">
                            <i class='bx bx-calendar-event'></i>
                            <span>Calendar</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/occasions">
                            <i class='bx bx-party'></i>
                            <span>Occasions</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/category">
                            <i class='bx bx-network-chart'></i>
                            <span>Category</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/products">
                            <i class='bx bxs-t-shirt'></i>
                            <span>Products</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/orders">
                            <i class='bx bx-box'></i>
                            <span>Orders</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/users">
                            <i class='bx bx-user'></i>
                            <span>Users</span>
                        </a>
                    </div>

                    <div class="color-third-500">
                        <a class="sidebar-icons" href="/file-manager">
                            <i class='bx bx-folder'></i>
                            <span>File Manager</span>
                        </a>
                    </div>

                </div>
            </div>
        </aside>

        <main class="overflow-y-auto d-flex flex-column row-gap-4" style="background-color: #F7F7F7">
            <header>
                <nav class="navbar navbar-expand-lg p-0 app-header sticky-top color-second-500-bg">
                    <div class="container-fluid d-flex justify-content-between">
                        <div class="d-flex flex-row">
                            <div class="ms-md-2 ms-1 color-third-500">
                                <a class="nav-icons" onclick="asideFunction()">
                                    <i class="bx bx-menu-alt-left fs-2"></i>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex flex-row">
                            <div class="me-md-3 me-2 btn-group">
                                <a class="nav-icons color-third-500" role="button" data-bs-toggle="dropdown"
                                    data-bs-display="static" aria-expanded="false">
                                    <img width="30px" height="30px" class="object-fit-cover border-radius"
                                        src="<?= session()->get('familyImage'); ?>"
                                        alt="<?= session()->get('familyImageAlt'); ?>">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-radius">
                                    <li class="">
                                        <div class="dropdown-header">
                                            <h6 class="mb-0 text-uppercase"><?= session()->get('familyName'); ?></h6>
                                            <small><?= session()->get('familyRole'); ?></small>
                                        </div>
                                    </li>
                                    <li class="">
                                        <a class="dropdown-item"
                                            href="/family/<?= \App\Libraries\SecurityLibrary::encryptUrlId(session()->get('familyId')); ?>">
                                            <i class='bx bx-user fs-5 me-2'></i>
                                            <span>My Profile</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="dropdown-item" href="/settings">
                                            <i class='bx bx-cog fs-5 me-2'></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a class="dropdown-item" href="/logout">
                                            <i class='bx bx-log-out fs-5 me-2'></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <section class="container-fluid px-3 px-md-4">
                <?= $this->renderSection('content') ?>
            </section>

            <footer class="py-3">
                <div class="container-fluid px-3 px-md-4 py-0">
                    <div class="d-flex justify-content-center">
                        <?php $founded = 2017; ?>
                        <?php $footerCopyrightYear = ($founded != date('Y')) ? ($founded . '-' . date('Y')) : $founded; ?>
                        <span data-anima>Adesam.com © <?= $footerCopyrightYear; ?>.</span>
                        <a href="<?= session()->get('developerHref'); ?>" class="mx-2"
                            data-anima><?= session()->get('developerName'); ?></a>
                        <span data-anima>All right reserved.</span>
                    </div>
                </div>
            </footer>
        </main>
    </div>


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