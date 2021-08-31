
<video autoplay muted loop id="renderVideo">
  <source src="<?= base_url() . 'assets/data/login_video.mp4'?>" type="video/mp4">
</video>

<!-- Login -->

<!-- /.login-logo -->
<div class="login-box-body">
    <div class="login-logo">
        <img src="<?= base_url() . 'assets/img/kppip-logo.png'?>" style="filter: drop-shadow(5px 5px 5px #888);" data-toggle="tooltip" title="Komite Percepatan Penyediaan Infrastruktur Prioritas">
    </div>
    <p class="login-box-msg">
        <b>Komite Percepatan Penyediaan Infrastruktur Prioritas</b>
    </p>

    <?php echo form_open("auth/login","id='' class='col s12'");?>
        <div class="form-group has-feedback">
            <?php echo form_input($username,'','id="email" name="email" class="form-control" placeholder="Username" required autofocus');?>
            <?php echo lang('login_identity_label', 'username', 'class="sr-only"');?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo form_input($password,'','id="password" name="password" class="form-control" placeholder="Password" required');?>
            <?php echo lang('login_password_label', 'password', 'class="sr-only"');?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-warning btn-block btn-flat">Sign In</button>
            </div>
        </div>
    <?php echo form_close();?>

</div>
<!-- /.login-box-body -->