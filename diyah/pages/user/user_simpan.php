<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['save'])){
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = md5($_POST['password']);
	$nama_user = mysqli_real_escape_string($conn, $_POST['nama_user']);
	$level = intval($_POST['level_user']);
	
	//cek username
	$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
	$n = mysqli_num_rows($query);
	if($n > 0) {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data. Username sudah ada.";
		exit;
	}
	//cek username
	
	$query = mysqli_query($conn, "INSERT INTO users VALUES(null, '$nama_user', '$username', '$password', $level, 'def_avatar.png')");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>