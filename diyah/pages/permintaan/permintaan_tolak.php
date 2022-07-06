<?php
error_reporting(0);
session_start();
include("../../inc/koneksi.php");

if(isset($_POST['tolak'])) {
	$kode_permintaan = intval($_POST['kode_permintaan']);
	$query = mysqli_query($conn, "UPDATE permintaan SET status=2 WHERE kode_permintaan=$kode_permintaan");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>