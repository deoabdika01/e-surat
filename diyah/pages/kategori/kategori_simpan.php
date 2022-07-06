<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['save'])){
	$kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
	$query = mysqli_query($conn, "INSERT INTO kategori VALUES(null, '$kategori')");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>