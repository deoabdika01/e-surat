<?php

session_start();

include("../../inc/koneksi.php");

$query = mysqli_query($conn, "update permintaan set notif = 0");

if ($query) {
    echo json_encode(['status' => true]);
}


