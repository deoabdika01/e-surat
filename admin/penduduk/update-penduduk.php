<?php
	include ('../../config/koneksi.php');

	$id = $_POST['id'];
	$nik = $_POST['fnik'];
	$pass = $_POST['fpass'];
	$nama = $_POST['fnama'];
	$tempat_lahir = $_POST['ftempat_lahir'];
	$tgl_lahir = $_POST['ftgl_lahir'];
	$jenis_kelamin = $_POST['fjenis_kelamin'];
	$agama = $_POST['fagama'];
	$jalan = addslashes($_POST['fjalan']);
	$dusun = $_POST['fdusun'];
	$rt = $_POST['frt'];
	$rw = $_POST['frw'];
	$desa = $_POST['fdesa'];
	$kecamatan = $_POST['fkecamatan'];
	$kota = $_POST['fkota'];
	
	$pekerjaan = $_POST['fpekerjaan'];
	
	$kewarganegaraan = $_POST['fkewarganegaraan'];


	$qUpdate = "UPDATE penduduk SET nik = '$nik', password = '$pass', nama = '$nama', tempat_lahir = '$tempat_lahir', tgl_lahir = '$tgl_lahir', jenis_kelamin = '$jenis_kelamin', agama = '$agama', jalan = '$jalan', dusun = '$dusun', rt = '$rt', rw = '$rw', desa = '$desa', kecamatan = '$kecamatan', kota = '$kota', pekerjaan = '$pekerjaan', kewarganegaraan = '$kewarganegaraan' WHERE id_penduduk='$id'";
	$update = mysqli_query($connect, $qUpdate);

	if($update){
		header('location:../penduduk/');
	}else{
	 	echo ("<script LANGUAGE='JavaScript'>window.alert('Gagal mengubah data penduduk'); window.location.href='../penduduk/'</script>");
	}
?>