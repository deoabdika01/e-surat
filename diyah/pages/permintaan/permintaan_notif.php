<?php

session_start();

include("../../inc/koneksi.php");

$query = mysqli_query($conn, "SELECT * FROM permintaan WHERE notif = 1");

$result['count'] = 0;
$result['data'] = [];
if ($query) {
    $result['count'] = mysqli_num_rows($query);
}

$query_two = mysqli_query($conn, "SELECT * FROM permintaan order by kode_permintaan DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($query_two)) {
    array_push($result['data'], $row);
}

echo json_encode($result);
