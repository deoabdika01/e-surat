<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['update'])){
	$kode_barang = intval($_POST['kode_barang']);
	$kode_kategori = $_POST['kode_kategori'];
	$nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
	$jumlah = $_POST['jumlah'];
	$tanggal_masuk = $_POST['tanggal_masuk'];
	$nilai_barang= $_POST['nilai_barang'];
	$negara_asal = mysqli_real_escape_string($conn, $_POST['negara_asal']);
	$satuan = $_POST['satuan'];
	$mata_uang = mysqli_real_escape_string($conn, $_POST['mata_uang']);
	$query = mysqli_query($conn, "UPDATE barang SET kode_kategori='$kode_kategori', nama_barang='$nama_barang', jumlah=$jumlah, tanggal_masuk='$tanggal_masuk', nilai_barang=$nilai_barang, negara_asal='$negara_asal', satuan='$satuan', mata_uang='$mata_uang' WHERE kode_barang=$kode_barang");
	if($query) {
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>