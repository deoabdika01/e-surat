<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['update'])){
	$kode_kategori = intval($_POST['kode_kategori']);
	$kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
	$query = mysqli_query($conn, "UPDATE kategori SET kategori='$kategori' WHERE kode_kategori=$kode_kategori");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>