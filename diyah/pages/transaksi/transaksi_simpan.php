<?php
error_reporting(0);
session_start();
include("../../inc/koneksi.php");

if(isset($_POST['save'])){
	$kode_barang = $_POST['kode_barang'];
	$quantity = floatval($_POST['quantity']);
	$kode_user = $_SESSION["kode"];
	
	$show = mysqli_query($conn, "SELECT * FROM barang, kategori WHERE barang.kode_kategori=kategori.kode_kategori AND kode_barang='$kode_barang'");	
	
	$data =  mysqli_fetch_assoc($show);
	$hasil = floatval($data['jumlah']) - $quantity;
	
	if($hasil < 0) {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data. Stok tidak mencukupi.";
	} else {
		$query = mysqli_query($conn, "UPDATE barang SET jumlah='$hasil' WHERE kode_barang='$kode_barang'");
		$query = mysqli_query($conn, "INSERT INTO transaksi VALUES(null, $kode_barang, $kode_user, $quantity, '".date("Y-m-d")."')");
		
		if($query) {
			if($hasil <= 5) {
				echo "berhasil<i class='fa fa-check'></i> Berhasil menyimpan data.<br/><br/><b>Stok sudah menipis! Hanya tersisa {$hasil}.</b>";
			} else {
				echo "berhasil<i class='fa fa-check'></i> Berhasil menyimpan data.";
			}
		} else {
			echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
		}
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>