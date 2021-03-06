<?php
	session_start();

	if(empty($_SESSION['nik']) ){
		header("location:../index.php");
	}else{
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="../assets/img/mini-logo.png">
	<title>e-Surat</title>
  	<link rel="stylesheet" href="../assets/fontawesome-5.10.2/css/all.css">
	<link rel="stylesheet" href="../assets/bootstrap-4.3.1/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
	<navbar class="navbar navbar-expand-lg navbar-dark bg-danger">
	  	<a class="navbar-brand ml-4 mt-1" href="../"><img src="../assets/img/logo2.png"></a>
	  	<button class="navbar-toggler mr-4 mt-3" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
	    	<span class="navbar-toggler-icon"></span>
	  	</button>

	  	<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
	    	<ul class="navbar-nav ml-auto mt-lg-3 mr-5 position-relative text-right">
	      		
	      		<li class="nav-item active">
	        		<a class="nav-link" href="#"><i class="fas fa-envelope"></i>&nbsp;BUAT SURAT</a>
	      		</li>
	      		<li class="nav-item">
	        		<a class="nav-link" href="../tentang/">TENTANG </a>
	      		</li>
	      		<li class="nav-item active ml-5">
					<a class="btn btn-dark" href="../login_masyarakat/logout.php"><i class="fas fa-sign-in-alt"></i>&nbsp;LOG OUT</a>
	      		</li>
	    	</ul>
	  	</div>
	</navbar>

	<div style="font-size: 35pt; font-weight: 500;"><p>NIK : <strong><?php echo $_SESSION['nik']; ?></strong></div>
<div class="container-fluid">
	<div style="max-height:cover; padding-top:30px; padding-bottom:60px; position:relative; min-height: 100%;">
		<div>
			<?php 
   	        	if(isset($_GET['pesan'])){
                   	if($_GET['pesan']=="berhasil"){
                  		echo "<div class='alert alert-success'><center>Berhasil membuat surat. Silahkan ambil surat di Kantor Desa dalam 2-3 hari kerja!</center></div>";
              		}else if ($_GET['pesan']=="gagal"){
						echo "<div class='alert alert-danger'><center>Gagal Masuk</center></div>";
					  }
              	}
           	?>
		</div>
		<div class="row">
			<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN</h5><br><br>
		        		<a href="surat_keterangan/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN BERKELAKUAN BAIK</h5><br>
		        		<a href="surat_keterangan_berkelakuan_baik/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	<div class="col-sm-3 mt-4">
		    	<div class="card">
		      	
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN DOMISILI</h5><br>
		        		<a href="surat_keterangan_domisili/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN KEPEMILIKAN KENDARAAN BERMOTOR</h5>
		        		<a href="surat_keterangan_kepemilikan_kendaraan_bermotor/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN PERHIASAN</h5><br>
		        		<a href="surat_keterangan_perhiasan/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT KETERANGAN USAHA</h5><br>
		        		<a href="surat_keterangan_usaha/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT LAPOR HAJATAN</h5><br><br>
		        		<a href="surat_lapor_hajatan/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
		  	<div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">SURAT PENGANTAR SKCK</h5><br><br>
		        		<a href="surat_pengantar_skck/" class="btn btn-info">BUAT SURAT</a>
		      		</div>
		    	</div>
		  	</div>
			  <div class="col-sm-3 mt-4">
		    	<div class="card">
		      		
		      		<div class="card-body text-center">
		        		<h5 class="card-title">Status</h5><br><br>
		        		<a href="status/" class="btn btn-info">Lihat Status</a>
		      		</div>
		    	</div>
		  	</div>
		</div>
	</div>
</div>
<div class="footer bg-dark text-center">
    <span class="text-light"><strong>Copyright &copy; 2021 .</strong> All rights reserved.</span>
</div>
</body>
</html>
<?php 
	}
?>