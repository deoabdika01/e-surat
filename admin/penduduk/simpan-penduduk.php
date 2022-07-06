<?php
    include ('../../config/koneksi.php');

    if (isset($_POST['submit'])){
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
        $kota = "Kabupaten " . $_POST['fkota'];
        $pekerjaan = $_POST['fpekerjaan'];
        $kewarganegaraan = $_POST['fkewarganegaraan'];
       

        $qCekPenduduk = mysqli_query($connect, "SELECT * FROM penduduk WHERE nik='$nik'");
        $row          = mysqli_num_rows($qCekPenduduk);

        if($row > 0){
            header('location:index.php?pesan=gagal-menambah');
        }else{
            $qTambahPenduduk = "INSERT INTO penduduk VALUES(NULL, '$nik', '$pass', '$nama', '$tempat_lahir', '$tgl_lahir', '$jenis_kelamin', '$agama', '$jalan', '$dusun', '$rt', '$rw', '$desa', '$kecamatan', '$kota',  '$pekerjaan', '$kewarganegaraan')";
            $tambahPenduduk = mysqli_query($connect, $qTambahPenduduk);
            if($tambahPenduduk){
                header("location:index.php");
            }
        }
    }
?>