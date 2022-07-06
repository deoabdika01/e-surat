<?php
    include ('../../config/koneksi.php');
  
    if (isset($_POST['submit'])){
        
        $jenis_surat = "Surat Keterangan";
        $nik = $_POST['fnik'];
        $keperluan = addslashes($_POST['fkeperluan']);
        $status_surat = "PENDING";
  

      
        $qTambahSurat = "INSERT INTO surat_keterangan (jenis_surat, nik, keperluan, status_surat) VALUES('$jenis_surat', '$nik', '$keperluan', '$status_surat')";
        $TambahSurat = mysqli_query($connect, $qTambahSurat);
        header("location:../index.php?pesan=berhasil");
    }
?>