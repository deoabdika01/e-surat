<?phpsession_start();include("../../inc/koneksi.php");$s = isset($_POST["search"]) ? mysqli_real_escape_string($conn, $_POST["search"]["value"]) : "";$p = isset($_POST["start"]) && $_POST["start"] != "" && is_numeric($_POST["start"]) ? intval($_POST["start"]) : 0;$e = isset($_POST["length"]) && $_POST["length"] != "" && is_numeric($_POST["length"]) ? intval($_POST["length"]) : 10;$c = array(    "transaksi.tanggal_transaksi",    "barang.kode_barang",    "barang.nama_barang",    "terkirim");$o = isset($_POST["order"]) ? array($c[intval($_POST["order"][0]["column"])], strtoupper($_POST["order"][0]["dir"])) : array($c[0], "DESC");$result["draw"] = $_POST["draw"];$dari = isset($_POST["dari"]) ? $_POST["dari"] : date("d-m-Y");$dari = explode("-", $dari);$dari = "{$dari[2]}-{$dari[1]}-{$dari[0]}";$sampai = isset($_POST["sampai"]) ? $_POST["sampai"] : date("d-m-Y");$sampai = explode("-", $sampai);$sampai = "{$sampai[2]}-{$sampai[1]}-{$sampai[0]}";$filter = "AND (transaksi.tanggal_transaksi BETWEEN '{$dari}' AND '{$sampai}')";$query = mysqli_query($conn, "SELECT tanggal_transaksi, kode_barang FROM transaksi GROUP BY tanggal_transaksi, kode_barang");$row = mysqli_num_rows($query);$result["recordsTotal"] = intval($row);$query = mysqli_query($conn, "	SELECT		transaksi.tanggal_transaksi,		barang.kode_barang	FROM		transaksi,		barang	WHERE		barang.kode_barang=transaksi.kode_barang		AND barang.nama_barang LIKE '%{$s}%'		{$filter}	GROUP BY		transaksi.tanggal_transaksi,		transaksi.kode_barang,		barang.nama_barang");$row = mysqli_num_rows($query);$result["recordsFiltered"] = intval($row);$query = mysqli_query($conn, "	SELECT		transaksi.tanggal_transaksi,		transaksi.kode_barang,		barang.nama_barang,		SUM(transaksi.quantity) AS terkirim	FROM		transaksi,		barang	WHERE		barang.kode_barang=transaksi.kode_barang		AND barang.nama_barang LIKE '%{$s}%'		{$filter}	GROUP BY		transaksi.tanggal_transaksi,		transaksi.kode_barang,		barang.nama_barang	ORDER BY {$o[0]} {$o[1]}	LIMIT {$p},{$e}");$result["data"] = array();$baris = 0;while ($row = mysqli_fetch_assoc($query)) {    array_push($result["data"], array(        date("d-m-Y", strtotime($row["tanggal_transaksi"])),        $row["kode_barang"],        htmlspecialchars($row["nama_barang"]),        number_format($row["terkirim"]),    ));    $baris++;}echo json_encode($result);?>