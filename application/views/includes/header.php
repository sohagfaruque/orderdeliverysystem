<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?> || Gasable APP Admin</title>
        <link href="<?php echo base_url('assets/css') ?>/main.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css') ?>/contentslider.css" />
        <script type="text/javascript" src="<?php echo base_url('assets/js') ?>/contentslider.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js') ?>/jquery.min.js"></script>  <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>
    </head>
    <body id="skin-blur-sunny" style="">
        <script src="<?php echo base_url('assets/admin_files') ?>/jquery.min.js"></script>
        <?php $current_url = $_SERVER['PHP_SELF']; ?>
        <!-- CSS -->
        <link href="<?php echo base_url('assets/admin_files') ?>/bootstrap.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/admin_files') ?>/animate.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/font-awesome-4.1.0/css') ?>/font-awesome.min.css" rel="stylesheet"/>

        <link href="<?php echo base_url('assets/admin_files') ?>/form.css" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/admin_files') ?>/style.css" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/admin_files') ?>/icons.css" rel="stylesheet"/>
        <link href="<?php echo base_url('assets/admin_files') ?>/generics.css" rel="stylesheet"/> 
        <script src="<?php echo base_url('assets/admin_files') ?>/jquery-ui.min.js"></script> <!-- jQuery UI -->
        <script src="<?php echo base_url('assets/admin_files') ?>/jquery.easing.1.3.js"></script> <!-- jQuery Easing - Requirred for Lightbox + Pie Charts-->
        <!-- Bootstrap -->
        <script src="<?php echo base_url('assets/admin_files') ?>/bootstrap.min.js"></script>
        <!--  Form Related -->
        <script src="<?php echo base_url('assets/admin_files') ?>/icheck.js"></script> <!-- Custom Checkbox + Radio -->
        <!-- UX -->
        <script src="<?php echo base_url('assets/admin_files') ?>/scroll.min.js"></script> <!-- Custom Scrollbar -->
        <!-- All JS functions -->

        <script src="<?php echo base_url('assets/admin_files') ?>/functions.js"></script>
        <!--custom alert-->
        <link rel="stylesheet" href="<?php echo base_url('assets/customjs'); ?>/customconfirm/alertify.core.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url('assets/customjs'); ?>/customconfirm/alertify.default.css" type="text/css" />
        <script src="<?php echo base_url('assets/customjs'); ?>/customconfirm/alertify.min.js"></script>
        <!-- custom alert -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/customjs/customalert/jNotify.jquery.css" type="text/css" />
        <script src="<?php echo base_url('assets'); ?>/customjs/customalert/jNotify.jquery.js"></script>
        <!-- <div class="left_countainer">
        
        -->   <header id="header" class="media">

            <a href="" id="menu-toggle"></a> 

            <a class="logoa pull-left" href="<?php echo base_url('dashboard'); ?>">Gas Bottle</a>

            <div class="media-body">
                <div class="media" id="top-menu">
                    <div class="pull-left tm-icon">
                        <a data-drawer="notifications1" class="drawer-toggle1" href="<?php echo base_url('login/logout') ?>"><i class="sa-top-updates"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                    <div id="time" class="pull-right">
                        <span id="hours"></span>:<span id="min"></span>:<span id="sec"></span>
                    </div>
                    <div class="media-body">
                        <input type="text" class="main-search">
                    </div>
                </div>
            </div>

        </header>

        <div class="clearfix"></div>
        <aside id="sidebar">
            <!-- Sidbar Widgets -->

            <div class="side-widgets overflow" tabindex="5000" style="overflow: hidden; outline: none;">

                <!-- Profile Menu -->

                <div class="text-center s-widget m-b-25 dropdown" id="profile-menu">

                    <a href="" data-toggle="dropdown" class="profile-pic animated">
                        <img class="" src="<?php echo base_url('assets') ?>/images/logo.png" alt=""/>

                    </a>

                    <ul class="dropdown-menu profile-menu">

                        <li><a href="general_settings.php">Settings</a> <i class="icon left"></i><i class="icon right"></i></li>

                        <li><a href="logout.php">Sign Out</a> <i class="icon left"></i><i class="icon right"></i></li>

                    </ul>
                </div>

                <!-- Calendar -->
                <!-- Feeds -->
                <!-- Projects -->
            </div>
            <!-- Side Menu -->
            <?php $uriSegment = $this->uri->segment(1); ?>
            <ul class="list-unstyled side-menu">

                <li class="<?php echo $uriSegment == 'dashboard' ? 'active' : ''; ?>">
                    <a class="sa-side-home" href="<?php echo base_url('dashboard') ?>">
                        <span class="menu-item">Dashboard</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'generalsettings' ? 'active' : ''; ?>">
                    <a class="sa-side-home" href="<?php echo base_url('generalsettings') ?>">
                        <span class="menu-item">General settings</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'cities' ? 'active' : ''; ?>">
                    <a class="sa-side-chart" href="<?php echo base_url('cities') ?>">
                        <span class="menu-item">Mange Cities</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'areas' ? 'active' : ''; ?>">
                    <a class="sa-side-folder" href="<?php echo base_url('areas') ?>">
                        <span class="menu-item">Mange Areas</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'distributors' ? 'active' : ''; ?>">
                    <a class="sa-side-ui" href="<?php echo base_url('distributors') ?>">
                        <span class="menu-item">Mange Distributors</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'users' ? 'active' : ''; ?>">
                    <a class="sa-side-photos" href="<?php echo base_url('users') ?>">
                        <span class="menu-item">Mange users</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'products' ? 'active' : ''; ?>">
                    <a class="sa-side-widget" href="<?php echo base_url('products') ?>">
                        <span class="menu-item">Mange products</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'orders' ? 'active' : ''; ?>">
                    <a class="sa-side-table" href="<?php echo base_url('orders') ?>">
                        <span class="menu-item">Mange orders</span>
                    </a>
                </li>
                <li class="<?php echo $uriSegment == 'feedback' ? 'active' : ''; ?>">
                    <a class="sa-side-table" href="<?php echo base_url('feedback') ?>">
                        <span class="menu-item">Mange Feedback</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- </div>
        
        </div> -->