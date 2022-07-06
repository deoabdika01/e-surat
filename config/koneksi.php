<?php
	$host 		= "localhost";
	$username 	= "root";
	$password 	= "";
	$db_name 	= "surat_desa";

	$connect = mysqli_connect($host,$username,$password,$db_name);

	if (mysqli_connect_errno()){
		echo "Koneksi Database Eror!" . mysqli_connect_error();
	}
?>