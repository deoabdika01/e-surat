<?php

error_reporting(0);
session_start();
include("../../inc/koneksi.php");

if (isset($_POST['save'])) {
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $jumlah = $_POST['jumlah'];
    $string = "INSERT INTO permintaan VALUES(null, '" . date("Y-m-d") . "', '$nama_barang', $jumlah, 0, {$_SESSION["kode"]}, 1)";
//    echo $string;
    $query = mysqli_query($conn, $string);
    if ($query) {
        echo "berhasil";
    } else {
        echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
    }
} else {
    echo "<i class='fa fa-times'></i> Gagal menyimpan data.";
}
?>