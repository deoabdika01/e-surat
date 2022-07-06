<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['hapus'])){
	$kode_kategori = intval($_POST['kode_kategori']);
	$query = mysqli_query($conn, "DELETE FROM kategori WHERE kode_kategori=$kode_kategori");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menghapus data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menghapus data.";
}
?>