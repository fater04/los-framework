<?php

use systeme\Application\Application as ap;

date_default_timezone_set('America/Port-au-Prince');
if (!\systeme\Model\Utilisateur::session()) {
    ap::redirection('login');
}
$user=new \systeme\Model\Utilisateur();
$u0=$user->findById(\systeme\Model\Utilisateur::session_valeur());
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
    <link rel="stylesheet" href="public/admin/assets/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="public/admin/assets/stylesheets/sweetalert2.min.css">
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
    <style>
        #ajax-loading {
            position: fixed;
            z-index: 9999;
            background: url("public/load.svg") 50% 50% no-repeat;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            cursor: wait;
        }
    </style>
</head>
<body>
<div id="ajax-loading"></div>
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

<!--                    <form class="top-bar-search col-6">-->
<!--                        <div class="input-group input-group-search dropdown">-->
<!--                            <div class="input-group-prepend">-->
<!--                                <span class="input-group-text"><span class="oi oi-magnifying-glass"></span></span>-->
<!--                            </div>-->
<!--                            <input type="text" class="form-control" placeholder="Search">-->
<!--                        </div>-->
<!--                    </form>-->
                </div>
                <div class="top-bar-item top-bar-item-right px-0 d-none d-sm-flex">
                    <div class="dropdown d-none d-md-flex">
                        <button class="btn-account" type="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <span class="user-avatar user-avatar-md">
                                <img src="public/admin/assets/images/avatars/profile.jpg" alt="">
                            </span>
                            <span class="account-summary pr-lg-4 d-none d-lg-block">
                                <span class="account-name"><?=$u0->getNom() ?></span>
                                <span class="account-description"><?=$u0->getEmail()?></span>
                            </span>
                        </button>
                        <div class="dropdown-menu">
                            <div class="dropdown-arrow d-lg-none" x-arrow=""></div>
                            <div class="dropdown-arrow ml-3 d-none d-lg-block"></div>
                            <a class="dropdown-item" href="<?= ap::genererUrl('change-password')?>"><span
                                        class="dropdown-icon oi oi-person"></span> Modifier mot de passe</a>
                            <a class="dropdown-item" href="<?= ap::genererUrl('logout')?>">
                                <span class="dropdown-icon oi oi-account-logout"></span> Se deconnecter</a>
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
<script src="public/admin/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="public/admin/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="public/admin/assets/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script> <!-- END PLUGINS JS -->
<script src="public/admin/assets/javascript/theme.min.js"></script>
<script src="public/admin/assets/javascript/sweetalert2.all.min.js"></script>
<script src="public/admin/assets/javascript/pages/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 4000);
    $(document).ready(function() {
        $("#ajax-loading").hide();
        $("#list_users").DataTable({
            "paging": true,
            "processing": true,
            "serverSide": true,
            "orderable": false,
            "order": [[1, "desc"]],
            "info": true,
            "ajax": {
                url: "app/DefaultApp/traitements/datatables.php?users",
                type: "POST"
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                }
            ],
        });

        $("#form_ajouter_utilisateur").submit(function (e) {
            $("#ajax-loading").show();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "app/DefaultApp/traitements/traitements.php?ajouter_utilisateur",
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#ajax-loading").hide();
                    var obj = $.parseJSON(data);
                    if (obj.status === "ok") {
                        Swal.fire({
                            icon: "success",
                            allowOutsideClick: false,
                            title: obj.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $("#list_users").DataTable().ajax.reload();
                        $("#form_ajouter_utilisateur")[0].reset();
                        $(".bd-example-modal-lg").modal("toggle");

                    }
                }
            });
        });
    });

</script>
</html>