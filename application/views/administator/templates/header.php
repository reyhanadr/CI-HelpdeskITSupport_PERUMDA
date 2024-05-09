<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width initial-scale=1.0">

    <title><?= $title ?></title>

    <!-- favicon -->

	<link rel="shortcut icon" type="image/png" href="<?= base_url()?>assets/img/logos/icon-perumda.png">

    <!-- GLOBAL MAINLY STYLES-->

    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />

    <!-- PLUGINS STYLES-->

        <link href="<?php echo base_url(); ?>./assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>./assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>./assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>./assets/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>./assets/vendors/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" />
    <!-- THEME STYLES-->

    <link href="<?php echo base_url(); ?>assets/css/main.min.css" rel="stylesheet" />

    <!-- PAGE LEVEL STYLES-->

    <style>

        .page-sidebar.sticky {

            position: fixed;

            top: 0;

            bottom: 0;

            overflow-y: auto;

        }

    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).ready(function () {

            var $sidebar = $('#sidebar');

            var offset = $sidebar.offset();

            var topPadding = 15; // Atur padding atas sesuai kebutuhan



            $(window).scroll(function () {

                if ($(window).scrollTop() > offset.top) {

                    $sidebar.addClass('sticky');

                } else {

                    $sidebar.removeClass('sticky');

                }

            });

        });

    </script>

</head>



<body class="fixed-navbar">

    <div class="page-wrapper">

        <!-- START HEADER-->

        <header class="header">

            <div class="page-brand">

                <a class="link" href="<?= base_url('index.php/Administator/Dashboard'); ?>">

                    <span class="brand">Administator

                    </span>

                    <span class="brand-mini">AD</span>

                </a>

            </div>

            <div class="flexbox flex-1">

                <!-- START TOP-LEFT TOOLBAR-->

                <ul class="nav navbar-toolbar">

                    <li>

                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>

                    </li>

                    <li>

                        <form class="navbar-search" action="<?php echo site_url('Administator/Dashboard/Search'); ?>" method="GET">

                            <div class="rel">

                                <span class="search-icon"><i class="ti-search"></i></span>

                                <input class="form-control" name="keyword" placeholder="Search User here...">

                            </div>

                        </form>

                    </li>

                </ul>

                <!-- END TOP-LEFT TOOLBAR-->

                <!-- START TOP-RIGHT TOOLBAR-->

                <ul class="nav navbar-toolbar">

                    <li class="dropdown dropdown-notification">

                        <a class="nav-link dropdown-toggle" data-toggle="dropdown">

                            <i class="fa fa-bell-o rel">

                                <span class="<?php if ($jml_notif > 0) { echo 'notify-signal'; } ?>"></span>

                            </i>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">

                            <li class="dropdown-menu-header">

                                <div>

                                    <span><strong><?php echo $jml_notif?> New</strong> Notifications</span>

                                    <a class="pull-right" href="<?= base_url()?>index.php/Administator/Dashboard/kelolaNotifikasi">view all</a>



                                </div>

                            </li>

                            <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">

                                <div>

                                <?php foreach ($notif as $notifikasi) : ?>

                                    <?php if ($notifikasi->request_id || $notifikasi->sesi_pesan && $notifikasi->teknisi_id === NULL) : ?>

                                        <a href="#" class="list-group-item">

                                            <div class="media">

                                                <div class="media-img">

                                                    <span class="badge badge-success badge-big">

                                                        <i class="fa fa-bell"></i>

                                                    </span>

                                                </div>

                                                <div class="media-body">

                                                    <div class="font-13"><?= $notifikasi->message_for_teknisi?></div>

                                                    <small class="text-muted"><?php echo $notifikasi->created_at; ?></small>

                                                </div>

                                            </div>

                                        </a>



                                    <?php endif; ?>

                                <?php endforeach; ?>

                                </div>

                            </li>

                        </ul>

                    </li>

                    <li class="dropdown dropdown-user">

                    <a class="nav-link dropdown-toggle link" data-toggle="dropdown">

                            <div style="width: 45px; height: 45px; overflow: hidden; border-radius: 50%; ">

                            <img src="<?php echo base_url(); ?>./assets/img/users/<?php echo $users->foto_user?>" alt="User Foto" style="width: 100%; height: 100%; object-fit: cover; ">

                            </div>

                            <div style="margin-left: 10px;">

                            <?php echo $this->session->userdata('username');?> 

                            </div>

                            <i class="fa fa-angle-down m-l-5"></i>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">

                            <a class="dropdown-item" href="<?= base_url('index.php/Administator/Profil/tampilEditProfile/') . $this->session->userdata('username'); ?>"><i

                                    class="fa fa-user"></i>My Profile</a>

                            <li class="dropdown-divider"></li>

                            <a class="dropdown-item" href="<?php echo base_url('index.php/Home/logout'); ?>"><i

                                    class="fa fa-power-off"></i>Logout</a>

                        </ul>

                    </li>

                </ul>

                <!-- END TOP-RIGHT TOOLBAR-->

            </div>

        </header>

        <!-- END HEADER-->