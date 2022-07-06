<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['update'])){
	$kode_user = intval($_POST['kode_user']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = !empty($_POST["password"]) ? ", password='".md5($_POST['password'])."'" : "";
	$nama_user = mysqli_real_escape_string($conn, $_POST['nama_user']);
	$level = mysqli_real_escape_string($conn, $_POST['level_user']);
	
	//cek username
	$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND kode_user<>$kode_user");
	$n = mysqli_num_rows($query);
	if($n > 0) {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data. Username sudah ada.";
		exit;
	}
	//cek username
	
	$query = mysqli_query($conn, "UPDATE users SET username='$username', nama_user='$nama_user', level='$level'{$password} WHERE kode_user=$kode_user");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>