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
		<link href="<?php echo base_url(); ?>./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
		<!-- PLUGINS STYLES-->
		<link href="<?php echo base_url(); ?>./assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>./assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>./assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>./assets/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>./assets/vendors/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" />
		<!-- THEME STYLES-->
		<link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" />
		<!-- PAGE LEVEL STYLES-->
	</head>
	<body class="fixed-navbar">
		<div class="page-wrapper">
		<!-- START HEADER-->
		<header class="header">
			<div class="page-brand">
				<a class="link" href="<?= base_url('index.php/Karyawan/Home'); ?>">
				<span class="brand">
				Karyawan
				<span class="brand-tip">Cast</span>
				</span>
				<span class="brand-mini">KC</span>
				</a>
			</div>
			<div class="flexbox flex-1">
				<!-- START TOP-LEFT TOOLBAR-->
				<ul class="nav navbar-toolbar">
					<li>
						<a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
					</li>
					<li>
						<form class="navbar-search" action="<?php echo site_url('/Karyawan/Dashboard/search'); ?>" method="GET">
							<div class="rel">
								<span class="search-icon"><i class="ti-search"></i></span>
								<input class="form-control" name="keyword" placeholder="Search here...">
							</div>
						</form>
					</li>
				</ul>
				<!-- END TOP-LEFT TOOLBAR-->
				<!-- START TOP-RIGHT TOOLBAR-->
				<ul class="nav navbar-toolbar">
					<li class="dropdown dropdown-inbox">
						<a href="<?php echo base_url()?>index.php/KelolaPesan/requestPesan" class="nav-link" >
							<i class="fa fa-envelope-o"></i>
							<!-- <span class="badge badge-primary envelope-badge">9</span> -->
						</a>
					</li>
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
								</div>
							</li>
							<li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
								<div>
									<?php foreach ($notif as $notifikasi) : ?>
									<?php if ($notifikasi->message_for_karyawan !== NULL) : ?>
									<a href="<?php echo ($notifikasi->status == 'taken') ? base_url('index.php/') . $notifikasi->link : ((!empty($notifikasi->sesi_pesan)) ? base_url('index.php') : base_url('index.php/Karyawan')) . '/' . $notifikasi->link; ?>" class="list-group-item">
										<div class="media">
											<div class="media-img">
												<span class="badge badge-success badge-big">
												<i class="fa fa-bell"></i>
												</span>
											</div>
											<div class="media-body">
												<div class="font-13"><?php echo ($notifikasi->status == 'taken') ? $notifikasi->message_for_karyawan : $notifikasi->message_for_karyawan; ?></div>
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
							<a class="dropdown-item" href="<?= base_url('index.php/Karyawan/Profil/tampilEditProfile/'.$this->session->userdata('username').''); ?>"><i
								class="fa fa-user"></i>My Profile</a>
							<li class="dropdown-divider"></li>
							<a class="dropdown-item" href="<?php echo base_url('index.php/Home/logout'); ?>"><i
								class="fa fa-power-off"></i>Logout</a>
						</ul>
					</li>
				</ul>
				<!-- END TOP-RIGHT TOOLBARS-->
			</div>
		</header>
		<!-- END HEADER-->