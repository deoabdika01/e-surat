<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['hapus'])){
	$kode_barang = intval($_POST['kode_barang']);
	$query = mysqli_query($conn, "DELETE FROM barang WHERE kode_barang=$kode_barang");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menghapus data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menghapus data.";
}
?>