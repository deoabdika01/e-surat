<?php
$base_url = "http://" . $_SERVER['HTTP_HOST'];
$base_url .= preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- jQuery 2.2.3 -->
        <script src="../../template/assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../../template/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../../template/assets/bootstrap/js/bootstrapValidator.js"></script>
        <!-- DataTables -->
        <script src="../../template/assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../../template/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="../../template/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../../template/assets/plugins/fastclick/fastclick.js"></script>
        <!-- Selectpicker -->
        <script src="../../template/assets/plugins/selectpicker/bootstrap-select.min.js"></script>
        <!-- Datepicker -->
        <script src="../../template/assets/plugins/datepicker/bootstrap-datepicker.min.js"></script>
        <!-- Dialog -->
        <script src="../../template/assets/plugins/dialog/bootstrap-dialog.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../../template/assets/dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../../template/assets/dist/js/demo.js"></script>
        <!-- CropIT -->
        <script src="../../template/assets/plugins/cropit/jquery.cropit.js"></script>


        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../../template/assets/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../template/assets/plugins/font-awesome/css/font-awesome.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../../template/assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Selectpicker -->
        <link rel="stylesheet" href="../../template/assets/plugins/selectpicker/bootstrap-select.min.css">
        <!-- Datepicker -->
        <link rel="stylesheet" href="../../template/assets/plugins/datepicker/bootstrap-datepicker.min.css">
        <!-- Dialog -->
        <link rel="stylesheet" href="../../template/assets/plugins/dialog/bootstrap-dialog.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../../template/assets/dist/css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../../template/assets/dist/css/skins/_all-skins.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            th {
                text-align: center;
            }
            .btn-aksi-sm-left, .btn-aksi-sm-right {
                height: 24px;
                padding: 1px;
            }
            .btn-aksi-sm-left {
                width: 24px;
                margin-right: 6px;
            }
            .btn-aksi-sm-right {
                width: 24px;
            }
        </style>
    </head>
    <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
    <!-- the fixed layout is not compatible with sidebar-mini -->
    <body class="hold-transition skin-red fixed sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="../../pages/dashboard/dashboard.php" class="logo" style="padding:0px;">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><img src="../../template/assets/images/logo_aplus.png" style="width:46px;"></span>
                    <!-- logo for regular state and mobile devices -->
                    <!-- <span class="logo-sm"><b style="font-size:17px">@BARATA INDONESIA</b></span> -->
                    <span class="logo-sm"><marquee><img src="../../template/assets/images/logo_aplus.png" style="width:70px;"></marquee></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <?php if ($_SESSION["level"] == 'gudang') { ?>
                                <li class="dropdown notifications-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="read()">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="label label-warning" id="notif-count">0</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <!-- inner menu: contains the actual data -->
                                            <ul class="menu" id="notif-list">

                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="../../template/assets/images/admin.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION["nama"]; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="../../template/assets/images/foto-profil/<?php echo $_SESSION["foto"]; ?>" class="img-circle" alt="User Image" id="foto_di_header">

                                        <p>
                                            PT. INDOSPRING Tbk. - Penerimaan Barang Masuk
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="../../pages/profile/profile.php" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="../../logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>