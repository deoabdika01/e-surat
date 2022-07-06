<?php
    include ('../../config/koneksi.php');

    if (isset($_POST['submit'])){
        $jenis_surat = "Surat Pengantar SKCK";
        $nik = $_POST['fnik'];
        $bukti_ktp = $_POST['fbukti_ktp'];
        $bukti_kk = $_POST['fbukti_kk'];
        $keperluan = addslashes($_POST['fkeperluan']);
        $keterangan = addslashes($_POST['fketerangan']);
        $status_surat = "PENDING";
        

        $qTambahSurat = "INSERT INTO surat_pengantar_skck (jenis_surat, nik, bukti_ktp, bukti_kk, keperluan, keterangan, status_surat) VALUES('$jenis_surat', '$nik', '$bukti_ktp', '$bukti_kk', '$keperluan', '$keterangan', '$status_surat')";
        $TambahSurat = mysqli_query($connect, $qTambahSurat);
        header("location:../index.php?pesan=berhasil");
    }
?>