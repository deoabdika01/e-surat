<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['hapus'])){
	$kode_permintaan = intval($_POST['kode_permintaan']);
	$query = mysqli_query($conn, "DELETE FROM permintaan WHERE kode_permintaan=$kode_permintaan");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menghapus data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menghapus data.";
}
?>