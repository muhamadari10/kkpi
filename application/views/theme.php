<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>KPPIP</title>

        <meta name="description" content="Komite Percepatan Penyediaan Infrastruktur Prioritas">
        <meta name="author" content="jivanly and IT Team">
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
        <script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('assets/bower_components/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <script src="<?= base_url('assets/dist/js/demo.js'); ?>"></script>
        
        <?php echo $plugin_css;?>
        <?php echo $css; ?>        

        <!-- <style type="text/css">
            .buttons-html5{
                background-color: #000;
            }
        </style> -->

        <!-- END Stylesheets -->
    </head>

    <!--script di atas menampilkan garis orange paling atas-->
    <body class="<?php echo $body_class; ?> skin-yellow-light">
        
        <div class="<?php echo $custom_class; ?>">
            <?php

                $content_list = array(
                    1 => $header,
                    2 => $menu,
                    3 => $content
                );

                for ($content = 1; $content <= count($content_list); $content++) { 
                    echo $content_list[$content];
                };

            ?>
            
        </div>

        <div class="control-sidebar-bg"></div>

        <script type="text/javascript">
            var base_url            = '<?=base_url();?>';
            var current_url         = "<?=current_url()?>";
        </script>


        <!-- Javascripts -->
        
        <script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('assets/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
        <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
        <script src="<?= base_url('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js'); ?>"></script>
        <script src="<?= base_url('assets/plugins/iCheck/icheck.min.js'); ?>"></script>
        <!-- own created -->
        <?php echo $plugin_js;?>
        <?php echo $js;?>
        <!-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->


    </body>

</html>
