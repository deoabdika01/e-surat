<?php
    include ('../../config/koneksi.php');

    if (isset($_POST['submit'])){
        $jenis_surat = "Surat Keterangan Domisili";
        $nik = $_POST['fnik'];
        $status_surat = "PENDING";
      

        $qTambahSurat = "INSERT INTO surat_keterangan_domisili (jenis_surat, nik, status_surat) VALUES('$jenis_surat', '$nik', '$status_surat')";
        $TambahSurat = mysqli_query($connect, $qTambahSurat);
        header("location:../index.php?pesan=berhasil");
    }
?>