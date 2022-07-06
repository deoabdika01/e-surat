<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['hapus'])){
	$kode_transaksi = intval($_POST['kode_transaksi']);
	$query = mysqli_query($conn, "DELETE FROM transaksi WHERE kode_transaksi=$kode_transaksi");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menghapus data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menghapus data.";
}
?>