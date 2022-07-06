<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['update'])){
	$kode_supplier = intval($_POST['kode_supplier']);
	$nomor = $_POST['nomor'];
	$tanggal_masuk = $_POST['tanggal_masuk'];
	$nopol = $_POST['nopol'];
	$nama_perusahaan = $_POST['nama_perusahaan'];
	$alamat= $_POST['alamat'];
	$nama_barang =  $_POST['nama_barang'];
	$banyak = $_POST['banyak'];

	echo $kode_supplier;
	$query = mysqli_query($conn, "UPDATE data_supplier SET nomor='$nomor', tanggal_masuk='$tanggal_masuk', nopol='$nopol', nama_perusahaan='$nama_perusahaan', alamat='$alamat', nama_barang='$nama_barang', banyak='$banyak' WHERE kode_supplier='$kode_supplier'");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>