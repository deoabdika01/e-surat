<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['save'])){
	$nomor = $_POST['nomor'];
	$tanggal_masuk = $_POST['tanggal_masuk'];
	$nopol = $_POST['nopol'];
	$nama_perusahaan = $_POST['nama_perusahaan'];
	$alamat = $_POST['alamat'];
	$nama_barang = $_POST['nama_barang'];
	$banyak = $_POST['banyak'];

	
	$query = mysqli_query($conn, "INSERT INTO data_supplier VALUES(null, '$nomor', '$tanggal_masuk', '$nopol', 
		'$nama_perusahaan', '$alamat','$banyak','$nama_barang')");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>