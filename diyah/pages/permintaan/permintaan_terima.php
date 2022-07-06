<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['terima'])){
	$kode_permintaan = $_POST['kode_permintaan'];
	$kode_kategori = $_POST['kode_kategori'];
	$nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
	$jumlah = $_POST['jumlah'];
	$tanggal_masuk = $_POST['tanggal_masuk'];
	$nilai_barang= $_POST['nilai_barang'];
	$negara_asal = mysqli_real_escape_string($conn, $_POST['negara_asal']);
	$satuan = $_POST['satuan'];
	$mata_uang = mysqli_real_escape_string($conn, $_POST['mata_uang']);
	$query = mysqli_query($conn, "INSERT INTO barang VALUES(null, '$kode_kategori', '$nama_barang', $jumlah, '$tanggal_masuk', $nilai_barang, '$negara_asal', '$satuan', '$mata_uang')");
	if($query) {
		$kode_barang = mysqli_insert_id($conn);
		$query = mysqli_query($conn, "UPDATE permintaan SET status=1 WHERE kode_permintaan=$kode_permintaan");
		if($query) {
			echo "berhasil";
		} else {
			mysqli_query($conn, "DELETE FROM barang WHERE kode_barang=$kode_barang");
			echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
		}
	} else {
		echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>