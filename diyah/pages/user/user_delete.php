<?php
error_reporting(0);
include("../../inc/koneksi.php");

if(isset($_POST['hapus'])){
	$kode_user = intval($_POST['kode_user']);
	$query = mysqli_query($conn, "SELECT foto FROM users WHERE kode_user=$kode_user");
	$row = mysqli_fetch_assoc($query);
	$nama_foto = "";
	
	if(file_exists("../../template/assets/images/foto-profil/{$row["foto"]}")) {
		if($row["foto"] != "def_avatar.png") {
			$nama_foto = "../../template/assets/images/foto-profil/{$row["foto"]}";
		}
	}
	
	$query = mysqli_query($conn, "DELETE FROM users WHERE kode_user=$kode_user");
	if($query) {
		if($nama_foto != "") {
			unlink($nama_foto);
		}
		echo "berhasil";
	} else {
		echo "<i class='fa fa-times'></i> Gagal menghapus data.";
	}
} else {
	echo "<i class='fa fa-times'></i> Gagal menghapus data.";
}
?>