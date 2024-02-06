<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Purchase: https://1.envato.market/nobleui_admin
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="keywords"
        content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>AMU - Akses Tamu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    <!-- core:css -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/core/core.css'); ?>">
    <!-- endinject -->

    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url('assets/fonts/feather-font/css/iconfont.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/flag-icon-css/css/flag-icon.min.css'); ?>">
    <!-- endinject -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/demo1/style.css'); ?>">
    <!-- End layout styles -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png'); ?>" />
    <style>
    .loader-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
    </style>
</head>

<body>
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="main-wrapper">

        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    Tamu<span>Access</span>
                </a>
                <div class="sidebar-toggler not-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="sidebar-body">
                <ul class="nav">
                    <li class="nav-item nav-category">Main</li>
                    <li class="nav-item <?= ($active_page == 'dashboard') ? 'active' : ''; ?>">
                        <a href="<?= base_url('dashboard'); ?>" class="nav-link">
                            <i class="link-icon" data-feather="home"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item <?= ($active_page == 'booking') ? 'active' : ''; ?>">
                        <a href="<?= base_url('booking'); ?>" class="nav-link">
                            <i class="link-icon" data-feather="book"></i>
                            <span class="link-title">Booking</span>
                        </a>
                    </li>

                    <li class="nav-item <?= ($active_page == 'open_class') ? 'active' : ''; ?>">
                        <a href="<?= base_url('class'); ?>" class="nav-link">
                            <i class="link-icon" data-feather="airplay"></i>
                            <span class="link-title">Open Class</span>
                        </a>
                    </li>

                    <?php if($role == 'admin'): ?>
                    <li class="nav-item <?= ($active_page == 'affiliate') ? 'active' : ''; ?>">
                        <a href="<?= base_url('affiliate'); ?>" class="nav-link">
                            <i class="link-icon" data-feather="link"></i>
                            <span class="link-title">Affiliate</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item <?= ($active_page == 'customers') ? 'active' : ''; ?>">
                        <a href="<?= base_url('customers'); ?>" class="nav-link">
                            <i class="link-icon" data-feather="users"></i>
                            <span class="link-title">Customers</span>
                        </a>
                    </li>

                    <li class="nav-item <?= ($active_page == 'bank') ? 'active' : ''; ?>">
                        <a href="<?= base_url('bank'); ?>" class="nav-link">
                            <i class="link-icon" data-feather="credit-card"></i>
                            <span class="link-title">Akun Bank</span>
                        </a>
                    </li>

                    <li class="nav-item <?= ($active_page == 'identity') ? 'active' : ''; ?>">
                        <a href="<?= base_url('setting'); ?>" class="nav-link">
                            <i class="link-icon" data-feather="settings"></i>
                            <span class="link-title">Settings</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:../../partials/_navbar.html -->
            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30"
                                    alt="profile">
                            </a>
                            <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                    <div class="mb-3">
                                        <img class="wd-80 ht-80 rounded-circle" src="https://via.placeholder.com/80x80"
                                            alt="">
                                    </div>
                                    <div class="text-center">
                                        <p class="tx-16 fw-bolder"><?= $username; ?></p>
                                    </div>
                                </div>
                                <ul class="list-unstyled p-1">
                                    <li class="dropdown-item py-2">
                                        <a href="<?= base_url('logout'); ?>" class="text-body ms-0">
                                            <i class="me-2 icon-md" data-feather="log-out"></i>
                                            <span>Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- partial -->