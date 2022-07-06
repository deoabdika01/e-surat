<?php
error_reporting(0);
session_start();
include("../../inc/koneksi.php");

if(isset($_POST['update'])) {
	$kode_permintaan = intval($_POST['kode_permintaan']);
	$nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
	$jumlah = $_POST['jumlah'];
	$query = mysqli_query($conn, "UPDATE permintaan SET nama_barang='$nama_barang', jumlah=$jumlah, kode_user={$_SESSION["kode"]} WHERE kode_permintaan=$kode_permintaan");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>