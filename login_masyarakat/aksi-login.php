<?php
	session_start();
	include ('../config/koneksi.php');	

	$nik 	= $_POST['nik'];
	$password 	= $_POST['password'];

	
	$qLogin 	= mysqli_query($connect, "SELECT * FROM penduduk WHERE nik='$nik' AND password='$password'");
	$row 		= mysqli_num_rows($qLogin);
	if($row == 1){
		$_SESSION['nik'] = $nik;
		header("location:../surat/");
	}else{
		header("location:../index.php?pesan=login-gagal");
	}

?>