<?php
session_start();

include("../../inc/koneksi.php");

$s = isset($_POST["search"]) ? mysqli_real_escape_string($conn, $_POST["search"]["value"]) : "";
$p = isset($_POST["start"]) && $_POST["start"] != "" && is_numeric($_POST["start"]) ? intval($_POST["start"]) : 0;
$e = isset($_POST["length"]) && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;
$c = array(
	
	"supplier.kode_supplier", 
	"supplier.nomor",
	"kategori.tgl_masuk",
	"supplier.nama_perusahaan",
	"supplier.alamat",
	"supplier.nama_barang",
	"supplier.banyak"
	
);
$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "DESC");

$result["draw"] = $_POST["draw"];

$query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang");
$row = mysqli_fetch_assoc($query);
$result["recordsTotal"] = intval($row["total"]);

$query = mysqli_query($conn, "SELECT COUNT(*) AS filtered FROM barang, kategori WHERE kategori.kode_kategori=barang.kode_kategori AND (barang.kode_barang LIKE '%{$s}%' OR barang.nama_barang LIKE '%{$s}%')");
$row = mysqli_fetch_assoc($query);
$result["recordsFiltered"] = intval($row["filtered"]);

$query = mysqli_query($conn, "SELECT * from data_supplier");

$result["data"] = array();
$baris = 0;

$admin = $_SESSION["level"] == "supplier";

while($row = mysqli_fetch_assoc($query)) {
	$tombol = array(
		"<button class='btn btn-success btn-tooltip btn-aksi-sm-left' onclick='edit({$baris});' title='Edit'><i class='fa fa-pencil'></i></button>",
		"<button class='btn btn-danger btn-tooltip btn-aksi-sm-right' onclick='hapus({$baris});' title='Hapus'><i class='fa fa-trash'></i></button>"
	);
	if($admin) {
		array_push($result["data"], array(
			$row["kode_supplier"],
			htmlspecialchars($row["nomor"]),
			$row["tgl_masuk"],
			htmlspecialchars($row["nopol"]),
			htmlspecialchars($row["nama_perusahaan"]),
			htmlspecialchars($row["alamat"]),
			htmlspecialchars($row["nama_barang"]),
			number_format($row["banyak"]),
			"<center><div style='width:88px;'>{$tombol[0]}{$tombol[1]}</div></center>",
			
		));
		$baris++;
	} else {
		array_push($result["data"], array(
			$row["kode_supplier"],
			htmlspecialchars($row["nomor"]),
			$row["tgl_masuk"],
			htmlspecialchars($row["nopol"]),
			htmlspecialchars($row["nama_perusahaan"]),
			htmlspecialchars($row["alamat"]),
			htmlspecialchars($row["nama_barang"]),
			number_format($row["banyak"]),
			
		));
	}
}
echo json_encode($result);
?>