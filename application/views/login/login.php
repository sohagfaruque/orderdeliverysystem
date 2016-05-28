<?php base_url() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gasable Admin Login</title>
        <link href="<?php echo base_url('assets') ?>/css/main.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
            <!-- CSS -->
            <link href="<?php echo base_url('assets/admin_files') ?>/bootstrap.min.css" rel="stylesheet"/>
            <link href="<?php echo base_url('assets/admin_files') ?>/animate.min.css" rel="stylesheet"/>
            <link href="<?php echo base_url('assets/admin_files') ?>/font-awesome.min.css" rel="stylesheet"/>
            <link href="<?php echo base_url('assets/admin_files') ?>/form.css" rel="stylesheet"/>

            <link href="<?php echo base_url('assets/admin_files') ?>/style.css" rel="stylesheet"/>
            <link href="<?php echo base_url('assets/admin_files') ?>/icons.css" rel="stylesheet"/>
            <link href="<?php echo base_url('assets/admin_files') ?>/generics.css" rel="stylesheet"/> 

            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

            <script src="<?php echo base_url('assets/admin_files') ?>/jquery-ui.min.js"></script> <!-- jQuery UI -->

            <script src="<?php echo base_url('assets/admin_files') ?>/jquery.easing.1.3.js"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->
            <script src="<?php echo base_url('assets/admin_files') ?>/bootstrap.min.js"></script>


            <!--  Form Related -->
            <script src="<?php echo base_url('assets/admin_files') ?>/icheck.js"></script> <!-- Custom Checkbox + Radio -->

            <script src="<?php echo base_url('assets/admin_files') ?>/scroll.min.js"></script> <!-- Custom Scrollbar -->


            <!-- All JS functions -->
            <script src="<?php echo base_url('assets/admin_files') ?>/functions.js"></script>

            <SCRIPT LANGUAGE="JavaScript" src="js/common.js"></SCRIPT>

    </head>
    <body id="skin-blur-sunny" style="">
        <section id="login">
            <div class="center">
                <div class="logo">
                    <img width="150px" src="<?php echo base_url('assets') ?>/images/logo.png" />
                </div>
                <div class="box1">
                    <form action="<?php echo base_url('login'); ?>"method="post" name="form_login" class="box tile animated active" id="box-login">
                        <h2 class="m-t-0 m-b-15">Login</h2>

                        <div class="form">
                            <?php
                            if (isset($errorMsg)) {
                                ?>
                                <div class="error_msg">
                                    <p class="alert alert-danger"><?php echo $errorMsg; ?></p>
                                </div>
                            <?php } ?>
                            <p>
                                <input type="text" class="login-control m-b-10" name="name" id="mgmt_name" value="" placeholder="Username" />
                                <?php echo form_error('name', '<p class="alert alert-danger">', '</p>'); ?>
                            </p>
                            <p>
                                <input type="password" class="login-control" name="password" id="mgmt_pwd"  placeholder="Password" />
                                <?php echo form_error('password', '<p class="alert alert-danger">', '</p>'); ?>
                            </p>
                            <!-- <div class="result">= 11</div> -->
                            <label style="display:none;" class="checkbox-inline" style="float:left"><span class="checkableBox">
                                    <input type="checkbox" name="rememberme" class="rememberme" value="1">
                                </span></label> <span style="display:none;">Remember me</span>
                            <input type="submit" class="btn btn-lg btn-success" value="Submit" name="Login">
                        </div>

                    </form>
                </div>

            </div>
        </section>
    </body>
</html>

