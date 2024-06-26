<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Login</title>
    <!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="<?= base_url()?>assets/img/logos/icon-perumda.png">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url(); ?>./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="<?php echo base_url(); ?>./assets/css/pages/auth-light.css" rel="stylesheet" />
</head>

<body class="bg-silver-300">
    <div class="content">
        <div class="brand mt-5 mb-4">
            <h1 class="login-title">Helpdesk IT Support</h1>
        </div>
        <form id="login-form" method="POST" action="<?php echo site_url('Home/login'); ?>" >
        <div class="text-center">
            <img class="img-circle" src="<?php echo base_url()?>assets/img/logos/logo-perumda.png" style="max-width: 100%; max-height: 100px; width: auto; height: auto;">
        </div>


            <!-- <h2 class="login-title">Log in</h2> -->
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
            </div>
            <!-- <div class="form-group d-flex justify-content-between">
                <a href="forgot_password.html">Forgot password?</a>
            </div> -->
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit">Login</button>
            </div>
        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="<?php echo base_url(); ?>./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript">
    </script>
    <script src="<?php echo base_url(); ?>./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript">
    </script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="<?php echo base_url(); ?>./assets/vendors/jquery-validation/dist/jquery.validate.min.js"
        type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="<?php echo base_url(); ?>assets/js/app.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
    $(function() {
        $('#login-form').validate({
            errorClass: "help-block",
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            highlight: function(e) {
                $(e).closest(".form-group").addClass("has-error")
            },
            unhighlight: function(e) {
                $(e).closest(".form-group").removeClass("has-error")
            },
        });
    });
    </script>
</body>

</html>