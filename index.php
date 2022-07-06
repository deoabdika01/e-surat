
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/img/mini-logo.png">
	<title>Login Masyarakat</title>   
	<link rel="stylesheet" href="assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/loginCSS/login_masyarakat.css">
</head>
<body>
<div class="container">
<navbar class="navbar navbar-expand-lg navbar-dark bg-transparent">
	  	  <a class="navbar-brand ml-4 mt-1" href="#"><img src="assets/img/logo2.png"></a>
	  	<button class="navbar-toggler mr-4 mt-3" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
	    	<span class="navbar-toggler-icon"></span>
	  	</button>

	  	<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
	    	<ul class="navbar-nav ml-auto mt-lg-3 mr-5 position-relative text-right">
	      		
	      		<li class="nav-item">
	        		<a class="nav-link" href="tentang/">TENTANG </a>
	      		</li>
	      		<li class="nav-item active ml-5">
	      				<?php
						session_start();
						if(empty($_SESSION['username'])){
						    echo '<a class="btn btn-dark" href="login/"><i class="fas fa-sign-in-alt"></i>&nbsp;LOGIN ADMIN</a>';
						}else if(isset($_SESSION['lvl'])){
							echo '<a class="btn btn-transparent text-light" href="admin/"><i class="fa fa-user-cog"></i> '; echo $_SESSION['lvl']; echo '</a>';
							echo '<a class="btn btn-transparent text-light" href="login/logout.php"><i class="fas fa-power-off"></i></a>';
						}
					?>
	      		</li>
	    	</ul>
	  	</div>
	</navbar>
	<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan']=="login-gagal"){
				echo "<div class='alert alert-danger'><center>NIK atau Password Anda salah!</center></div>";
			}
		}
	?>

	<div class="d-flex justify-content-center ">
		<div class="card">
			<div class="card-header text-center mt-4">
				<h3>Login E-Surat</h3>
			</div>
			<div class="card-body">
				<form method="post" action="login_masyarakat/aksi-login.php">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" name="nik" placeholder="Nik" required>			
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" name="password" placeholder="Password" required>
					</div><br>
					<div class="form-group">
						<input type="submit" value="Login" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					<span style="font-size:8pt">Copyright &copy; 2021</span>
				</div>
				<div class="d-flex justify-content-center">
					<span class="text-white" style="font-size:8pt">All rights reserved.</span>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>