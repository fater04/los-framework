<?php

use systeme\Application\Application as ap;

date_default_timezone_set('America/Port-au-Prince');
if (!\systeme\Model\Utilisateur::session()) {
    ap::redirection('login');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php if (isset($titre)) echo $titre; ?></title>
    <meta name="theme-color" content="#3063A0">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet">
    <link rel="stylesheet" href="public/admin/assets/vendor/open-iconic/font/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="public/admin/assets/vendor/fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="public/admin/assets/vendor/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="public/admin/assets/stylesheets/theme.min.css" data-skin="default">
    <link rel="stylesheet" href="public/admin/assets/stylesheets/theme-dark.min.css" data-skin="dark">
    <link rel="stylesheet" href="public/admin/assets/stylesheets/custom.css">
    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        disabledSkinStylesheet.setAttribute('rel', '');
        disabledSkinStylesheet.setAttribute('disabled', true);
        document.querySelector('html').classList.add('loading');
    </script>
</head>
<body>

<div class="app">
    <!--[if lt IE 10]>
    <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <span
            class="alert-link" >upgrade your browser</span> to improve your experience and
        security.
    </div>
    <![endif]-->

    <header class="app-header app-header-dark">
        <div class="top-bar">

            <div class="top-bar-brand">

                <button class="hamburger hamburger-squeeze mr-2" type="button" data-toggle="aside-menu"
                        aria-label="toggle aside menu">
                    <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                </button>
                <a href="javascript:void(0)"> DEMO</a>
            </div>
            <div class="top-bar-list">
                <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
                    <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside"
                            aria-label="toggle menu">
                        <span class="hamburger-box"><span class="hamburger-inner"></span></span>
                    </button>
                </div>
                <div class="top-bar-item top-bar-item-full">

                    <form class="top-bar-search col-6">
                        <div class="input-group input-group-search dropdown">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><span class="oi oi-magnifying-glass"></span></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                    </form>
                </div>
                <div class="top-bar-item top-bar-item-right px-0 d-none d-sm-flex">

                    <ul class="header-nav nav">
                        <li class="nav-item dropdown header-nav-dropdown has-notified">
                            <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false"><span class="oi oi-envelope-open"></span></a>
                            <!-- .dropdown-menu -->
                            <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                                <div class="dropdown-arrow"></div>
                                <h6 class="dropdown-header stop-propagation">
                                    <span>Messages</span> <a href="#">Mark all as read</a>
                                </h6><!-- .dropdown-scroll -->
                                <div class="dropdown-scroll perfect-scrollbar">
                                    <!-- .dropdown-item -->
                                    <a href="#" class="dropdown-item unread">
                                        <div class="user-avatar">
                                            <img src="public/admin/assets/images/avatars/team1.jpg" alt="">
                                        </div>
                                        <div class="dropdown-item-body">
                                            <p class="subject"> Stilearning </p>
                                            <p class="text text-truncate"> Invitation: Joe's Dinner @ Fri Aug 22 </p>
                                            <span class="date">2 hours ago</span>
                                        </div>
                                    </a> <!-- /.dropdown-item -->
                                    <!-- .dropdown-item -->
                                    <a href="#" class="dropdown-item">
                                        <div class="user-avatar">
                                            <img src="public/admin/assets/images/avatars/team3.png" alt="">
                                        </div>
                                        <div class="dropdown-item-body">
                                            <p class="subject"> Openlane </p>
                                            <p class="text text-truncate"> Final reminder: Upgrade to Pro </p><span
                                                    class="date">23 hours ago</span>
                                        </div>
                                    </a> <!-- /.dropdown-item -->
                                    <!-- .dropdown-item -->
                                    <a href="#" class="dropdown-item">
                                        <div class="tile tile-circle bg-green"> GZ</div>
                                        <div class="dropdown-item-body">
                                            <p class="subject"> Gogo Zoom </p>
                                            <p class="text text-truncate"> Live healthy with this wireless sensor. </p>
                                            <span class="date">1 day ago</span>
                                        </div>
                                    </a> <!-- /.dropdown-item -->
                                    <!-- .dropdown-item -->
                                    <a href="#" class="dropdown-item">
                                        <div class="tile tile-circle bg-teal"> GD</div>
                                        <div class="dropdown-item-body">
                                            <p class="subject"> Gold Dex </p>
                                            <p class="text text-truncate"> Invitation: Design Review @ Mon Jul 7 </p>
                                            <span class="date">1 day ago</span>
                                        </div>
                                    </a> <!-- /.dropdown-item -->
                                    <!-- .dropdown-item -->
                                    <a href="#" class="dropdown-item">
                                        <div class="user-avatar">
                                            <img src="public/admin/assets/images/avatars/team2.png" alt="">
                                        </div>
                                        <div class="dropdown-item-body">
                                            <p class="subject"> Creative Division </p>
                                            <p class="text text-truncate"> Need some feedback on this please </p><span
                                                    class="date">2 days ago</span>
                                        </div>
                                    </a> <!-- /.dropdown-item -->
                                    <!-- .dropdown-item -->
                                    <a href="#" class="dropdown-item">
                                        <div class="tile tile-circle bg-pink"> LD</div>
                                        <div class="dropdown-item-body">
                                            <p class="subject"> Lab Drill </p>
                                            <p class="text text-truncate"> Our UX exercise is ready </p><span
                                                    class="date">6 days ago</span>
                                        </div>
                                    </a> <!-- /.dropdown-item -->
                                </div><!-- /.dropdown-scroll -->
                                <a href="page-messages.html" class="dropdown-footer">All messages <i
                                            class="fas fa-fw fa-long-arrow-alt-right"></i></a>
                            </div><!-- /.dropdown-menu -->
                        </li>
                    </ul>
                    <div class="dropdown d-none d-md-flex">
                        <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <span class="user-avatar user-avatar-md">
                                <img src="public/admin/assets/images/avatars/profile.jpg" alt="">
                            </span>
                            <span class="account-summary pr-lg-4 d-none d-lg-block">
                                <span class="account-name">Beni Arisandi</span>
                                <span class="account-description">Marketing Manager</span>
                            </span>
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-arrow d-lg-none" x-arrow=""></div>
                            <div class="dropdown-arrow ml-3 d-none d-lg-block"></div>
                            <h6 class="dropdown-header d-none d-md-block d-lg-none"> Beni Arisandi </h6>
                            <a class="dropdown-item" href="#"><span
                                        class="dropdown-icon oi oi-person"></span> Profile</a>
                            <a class="dropdown-item" href="<?= ap::genererUrl('logout')?>">
                                <span class="dropdown-icon oi oi-account-logout"></span> Logout</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Help Center</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <aside class="app-aside app-aside-expand-md app-aside-light">
        <div class="aside-content">
            <header class="aside-header d-block d-md-none">
                <button class="btn-account" type="button" data-toggle="collapse" data-target="#dropdown-aside"><span
                            class="user-avatar user-avatar-lg">
                        <img src="public/admin/assets/images/avatars/profile.jpg" alt=""></span> <span class="account-icon">
                        <span class="fa fa-caret-down fa-lg"></span></span> <span class="account-summary"><span
                                class="account-name">Beni Arisandi</span> <span class="account-description">Marketing Manager</span></span>
                </button>
                <div id="dropdown-aside" class="dropdown-aside collapse">
                    <div class="pb-3">
                        <a class="dropdown-item" href="#"><span
                                    class="dropdown-icon oi oi-person"></span> Profile</a>
                        <a class="dropdown-item" href="<?= ap::genererUrl('logout')?>">
                            <span class="dropdown-icon oi oi-account-logout"></span> Logout</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Help Center</a>
                    </div>
                </div>
            </header>
            <div class="aside-menu overflow-hidden">

                <nav id="stacked-menu" class="stacked-menu">
                    <ul class="menu">
                        <li class="menu-item has-active">
                            <a href="<?=ap::genererUrl('dashboard')?>" class="menu-link"><span class="menu-icon fas fa-home"></span> <span
                                        class="menu-text">Dashboard</span></a>
                        </li>
                        <li class="menu-item has-child">
                            <a href="#" class="menu-link"><span class="menu-icon oi oi-browser"></span> <span
                                        class="menu-text">Layouts</span></a>
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="#" class="menu-link">Blank Page</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="#" class="menu-link"><span class="menu-icon fas fa-rocket"></span>
                                <span class="menu-text">Landing Page</span></a>
                        </li>
                        <li class="menu-header">Setting</li>
                        <li class="menu-item">
                            <a href="<?=ap::genererUrl('users')?>" class="menu-link"><span class="menu-icon fas fa-rocket"></span>
                                <span class="menu-text">USERS</span></a>
                        </li>

                    </ul>
                </nav>
            </div>
            <footer class="aside-footer border-top p-2">
                <button class="btn btn-light btn-block text-primary" data-toggle="skin"><span
                        class="d-compact-menu-none">Night mode</span> <i class="fas fa-moon ml-1"></i></button>
            </footer>
        </div>
    </aside>

    <main class="app-main">
        <div class="wrapper">

            <div class="page">
                <div class="page-inner">
                    <?php
                    $msg = new \Plasticbrain\FlashMessages\FlashMessages();
                    echo $msg->display();
                    if (isset($contenue)) {
                        echo $contenue;
                    } else {
                        echo "pas de contenue";
                    }
                    ?>
                </div>
            </div>
        </div>
        <footer class="app-footer">
            <div class="copyright"> Copyright © <?= Date('Y') ?>. All right reserved.</div>
        </footer>
    </main>
</div>
<script src="public/admin/assets/vendor/jquery/jquery.min.js"></script>
<script src="public/admin/assets/vendor/popper.js/umd/popper.min.js"></script>
<script src="public/admin/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="public/admin/assets/vendor/pace-progress/pace.min.js"></script>
<script src="public/admin/assets/vendor/stacked-menu/js/stacked-menu.min.js"></script>
<script src="public/admin/assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="public/admin/assets/vendor/flatpickr/flatpickr.min.js"></script>
<script src="public/admin/assets/vendor/easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="public/admin/assets/vendor/chart.js/Chart.min.js"></script>
<script src="public/admin/assets/javascript/theme.min.js"></script>
<script src="public/admin/assets/javascript/pages/dashboard-demo.js"></script>
<script type="text/javascript">
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 4000);
</script>
</html>