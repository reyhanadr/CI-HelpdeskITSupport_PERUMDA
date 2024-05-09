<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Admincast bootstrap 4 &amp; angular 5 admin template, Шаблон админки | Login</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?= base_url()?>./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?= base_url()?>assets/css/main.css" rel="stylesheet" />
</head>

<body class="bg-silver-100">
    <div class="content">
        <h1 class="m-t-20">404</h1>
        <p class="error-title">PAGE NOT FOUND</p>
        <p class="m-b-20">Sorry, the page you were looking for could not found. Please check the URL and try your luck again.
            <?php if ($this->session->userdata("role_id") == "2"): ?>
                <a class="color-green" href="<?= base_url()?>index.php/Karyawan/Dashboard">Go homepage</a>
            <?php elseif ($this->session->userdata("role_id") == "3"): ?>
                <a class="color-green" href="<?= base_url()?>index.php/Teknisi/Dashboard">Go homepage</a>
            <?php endif;?>
        </p>
    </div>
    <style>
        .content {
            max-width: 450px;
            margin: 0 auto;
            text-align: center;
        }

        .content h1 {
            font-size: 160px
        }

        .error-title {
            font-size: 22px;
            font-weight: 500;
            margin-top: 30px
        }
    </style>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="<?= base_url()?>./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?= base_url()?>./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="<?= base_url()?>./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?= base_url()?>assets/js/app.js" type="text/javascript"></script>
</body>

</html>