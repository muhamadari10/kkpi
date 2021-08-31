<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>KPPIP</title>

        <meta name="description" content="Komite Percepatan Penyediaan Infrastruktur Prioritas">
        <meta name="author" content="jivan">
        <meta name="keywords" content="Komite Percepatan Penyediaan Infrastruktur Prioritas, KPPIP, kppip, komite percepatan, infrastruktur">
        <meta name="robots" content="noindex, nofollow">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>"/>
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css'); ?>"/>
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/bower_components/Ionicons/css/ionicons.min.css'); ?>"/>
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css'); ?>"/>
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/dist/css/skins/_all-skins.min.css'); ?>"/>
        <link type="text/css" rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/all.css'); ?>"/>
        
        <!-- <link href="<?= base_url('assets/css/font.css'); ?>" rel="stylesheet"> -->

        <!-- END Stylesheets -->

        <link href="https://www.amcharts.com/lib/3/ammap.css" rel="stylesheet">
        <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
        <script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
        <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
        
    </head>

    <!--script di atas menampilkan garis orange paling atas-->
    <body class="login-page skin-yellow-light">
        
        <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

            <p>
                <?php 

                    if ( isset($_SESSION["error_status"]) ) {
                        
                        echo '<b>' . @$_SESSION["error_status"] . '</b>';
                        echo '<br/><a href="' . base_url() . 'Auth/auth/logout' . '">Logout and Contact Administrator</a>';
                    
                    } else {

                        echo 'We could not find the page you were looking for. Meanwhile, you may <a href="' . base_url() . 'Dashboard' . '">return to dashboard</a> or try using the search form.';

                    }
                    
                ?>
                
            </p>
            <p>
                
            </p>

            </div>
            <!-- /.error-content -->
        </div>

        <script type="text/javascript">
            var base_url            = '<?=base_url();?>';
            var current_url         = "<?=current_url()?>";
        </script>


        <!-- Javascripts -->
        <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('assets/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
        <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
        <script src="<?= base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
        <script src="<?= base_url('assets/dist/js/demo.js'); ?>"></script>
        <script src="<?= base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
        <!-- own created -->
    </body>

</html>