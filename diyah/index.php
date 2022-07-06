<?php
session_start();
if($_SESSION) {
	header("location:pages/dashboard/dashboard.php");
} else {
	$salah = false;
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>Sistem Penerimaan Barang Masuk Pergudangan</title>
	<meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!--[if !IE]> -->
	<script src="template/assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
	<script src="template/assets/plugins/jQuery/jquery.validate.min.js"></script>
	<script src="template/assets/bootstrap/js/bootstrap.min.js"></script>

	<!-- <![endif]-->
	<!--[if IE]>
	<script src="template/assets/plugins/jQuery/jquery-1.11.3.min.js"></script>
	<![endif]-->


	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="template/assets/plugins/fonts-googleapis-com/fonts-googleapis-com.css" />
	<link rel="stylesheet" href="template/assets/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="template/assets/plugins/ace/ace.min.css" />
	<link rel="stylesheet" href="template/assets/plugins/ace/ace-rtl.min.css" />
	<link rel="stylesheet" href="template/assets/plugins/font-awesome/css/font-awesome.min.css" />
</head>

<body class="login-layout blur-login">
<div class="main-container">
<div class="main-content">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">
<div class="login-container">
<div class="center">
	<h1>
		<img src="template/assets/images/logo_aplus.png" style = "width:60px;height:30px;">
		<span class="red">PT. INDOSPRING Tbk.</span>
	</h1>
	<span class="" style= "color:white;">Sistem Penerimaan Barang Pergudangan</span>
</div>
<?php
	if(isset($_POST['login'])){
		
		include("inc/koneksi.php");
		
		$username	= mysqli_real_escape_string($conn, $_POST['username']);
		$password	= md5($_POST['password']);
		
		$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
		
		if(mysqli_num_rows($query) == 0){
			$salah = true;
		} else {
			$row = mysqli_fetch_assoc($query);
			$level = intval($row["level"]);
			
			if($level == 1) {
				$_SESSION["kode"] = $row["kode_user"];
				$_SESSION["username"] = $username;
				$_SESSION["nama"] = $row["nama_user"];
				$_SESSION["foto"] = $row["foto"];
				$_SESSION["level"] = "supplier";
				header("location:pages/dashboard/dashboard.php");
			} else if($level == 2) {
				$_SESSION["kode"] = $row["kode_user"];
				$_SESSION["username"] = $username;
				$_SESSION["nama"] = $row["nama_user"];
				$_SESSION["foto"] = $row["foto"];
				$_SESSION["level"] = "pegawai_gudang";
				header("location:pages/dashboard/dashboard.php");
			} else if($level == 3) {
				$_SESSION["kode"] = $row["kode_user"];
				$_SESSION["username"] = $username;
				$_SESSION["nama"] = $row["nama_user"];
				$_SESSION["foto"] = $row["foto"];
				$_SESSION["level"] = "quality_control";
				header("location:pages/dashboard/dashboard.php");
			}else {
				$salah = true;
			}
		}
	}
?>
<div class="space-12"></div>
<div class="space-12"></div>
<div id="loading" style="text-align: center"></div>
<div class="position-relative">
	<div id="login-box" class="login-box visible widget-box no-border">
		<div class="widget-body">
			<div class="widget-main">
				<h4 class="header blue lighter bigger">
					<i class="ace-icon fa fa-home green"></i>
					Log In System
				</h4>

				<div class="space-6"></div>

				<form name="form" id="loginF" method="post" action="" class="form-horizontal">
					<fieldset>
					
					
						<div class="form-group">
						<label class="block clearfix">
							<span class="block input-icon input-icon-right">
								<input type="text"  name="username" id="username" value="" class="form-control"  placeholder="Username" />
								<i class="ace-icon fa fa-user"></i>
							</span>
						</label>
						</div>
						
						<div class="form-group">
						<label class="block clearfix">
								<span class="block input-icon input-icon-right">
									<input type="password" name="password"  value="" id="password" class="form-control" placeholder="Password" />
									<i class="ace-icon fa fa-lock"></i>
								</span>
						</label>
						</div>
							<button type="submit" name="login" class="btn btn-sm btn-primary btn-block">
								<i class="ace-icon fa fa-key"></i>
								<span class="bigger-110">Login</span>
							</button>
						<?php if($salah) { ?>
							<div class="space-12"></div>
							<div style="width:100%;text-align:center;font-weight:bold;color:red;">Maaf, Username atau Password salah!</div>
						<?php } ?>
						<div class="space-4"></div>
					</fieldset>
				</form>
			</div>
		</div><!-- /.widget-body -->
	</div><!-- /.login-box -->

</div>
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.main-content -->
</div><!-- /.main-container -->

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
		$(document).on('click', '.toolbar a[data-target]', function(e) {
			e.preventDefault();
			var target = $(this).data('target');
			$('.widget-box.visible').removeClass('visible');//hide others
			$(target).addClass('visible');//show target
		});
	});
	//you don't need this, just used for changing background
	jQuery(function($) {
		$('#btn-login-dark').on('click', function(e) {
			$('body').attr('class', 'login-layout');
			$('#id-text2').attr('class', 'white');
			$('#id-company-text').attr('class', 'blue');
			e.preventDefault();
		});
		$('#btn-login-light').on('click', function(e) {
			$('body').attr('class', 'login-layout light-login');
			$('#id-text2').attr('class', 'grey');
			$('#id-company-text').attr('class', 'blue');
			e.preventDefault();
		});
		$('#btn-login-blur').on('click', function(e) {
			$('body').attr('class', 'login-layout blur-login');
			$('#id-text2').attr('class', 'white');
			$('#id-company-text').attr('class', 'light-blue');
			e.preventDefault();
		});
		
		$(document).ready(function() {
			$("#username").focus();
		});
	});
</script>
</body>
</html>
<?php
}
?>