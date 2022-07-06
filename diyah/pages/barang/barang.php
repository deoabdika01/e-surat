<?php
session_start();
if(empty($_SESSION)) {
	header("location:../../index.php");
} else {
	include("../../inc/koneksi.php");
	include("../../template/header.php");
	include("../../template/sidebar.php");
?>
<title>Barang</title>
<section class="content">
	<div class="box">
		<div class="col-xs-12">
			<h2 class="page-header">
				<?php echo $_SESSION["level"] == "biro_pengadaan" ? "Laporan Stok Barang" : "Data Barang"; ?>
				<?php if($_SESSION["level"] == "gudang" || $_SESSION["level"] == "biro_pengadaan" || $_SESSION["level"] == "manager") { ?>
				<small class="pull-right">
					<?php if($_SESSION["level"] == "gudang") { ?>
					<button class="btn btn-xs btn-primary" onclick="tambah();"><i class="fa fa-plus"></i> Add Data</button>
					<?php } ?>
					<button class="btn btn-xs btn-success" onclick="print_laporan();"><i class="fa fa-print"></i> Print Laporan</button>
				</small>
				<?php } ?>
			</h2>
		</div>
		<div class="box-body">
			<table class="table table-bordered table-striped" style="width:100%;" id="tabel">
				<thead>
					<tr>
						<th>Kode Barang</th>
						<th>Periode Bulan</th>
						<th>Spesifikasi</th>
						<th>Roll</th>
						<th>PCS</th>
						<th>KG</th>
						<th colspan="2">Satuan</th>
						<th>Nilai Barang</th>
						<th>Mata Uang</th>
						<?php if($_SESSION["level"] == "supplier") { ?>
						<th>Aksi</th>
						<?php } ?>
					</tr>
					<tr>
						<th>wadwada</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</section>
<div class="modal fade" id="dlg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<h4 class="modal-title" id="judul_modal">Tambah Data Barang</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="kode_barang">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Barang</label>
							<input type="text" class="form-control" id="nama_barang" placeholder="Nama Barang">
						</div>
						<div class="form-group">
							<label>Kategori</label>
							<select class="form-control selectpicker" data-live-search="true" id="kode_kategori" title="-- Pilih Kode Kategori --">
								<option value='' data-hidden='true'></option>
								<?php
									$query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY kategori ASC");
									while($row = mysqli_fetch_assoc($query)) {
										echo "<option value='".$row["kode_kategori"]."'>".htmlspecialchars($row["kategori"])."</option>";
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Jumlah</label>
							<input type="number" class="form-control" id="jumlah" min="0" value="0" placeholder="Jumlah">
						</div>
						<div class="form-group">
							<label>Tanggal Masuk</label>
							<input type="text" class="form-control" id="tanggal_masuk" value="<?php echo date("Y-m-d"); ?>" readonly="readonly" style="background-color:#fff;cursor:pointer;">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Nilai Barang</label>
							<input type="number" class="form-control" id="nilai_barang" min="0" value="0" placeholder="Nilai Barang">
						</div>
						<div class="form-group">
							<label>Negara Asal</label>
							<input type="text" class="form-control" id="negara_asal" placeholder="Negara Asal">
						</div>
						<div class="form-group">
							<label>Satuan</label>
							<input type="text" class="form-control" id="satuan" placeholder="Satuan">
						</div>
						<div class="form-group">
							<label>Mata Uang</label>
							<input type="text" class="form-control" id="mata_uang" placeholder="Mata Uang">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-info btn-loading" onclick="simpan();" id="input_simpan"><i class="fa fa-save"></i>&nbsp;Save</button>
				<button class="btn btn-info btn-loading" onclick="update();" id="input_update"><i class="fa fa-save"></i>&nbsp;Update</button>
				<button class="btn btn-default btn-loading" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Batal</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var TabelData;
	$(document).ready(function() {
		TabelData = $("#tabel").DataTable({
			"processing": true,
			"serverSide": true,
			"searchDelay": 1000,
			"ajax": {
				"url": "barang_ambil.php",
				"type": "POST"
			},
			"drawCallback": function(settings) {
				if(settings.aiDisplay.length > 0) {
					$(".btn-tooltip").tooltip({"trigger": "hover"});
				}
			},
			"order": [[0, "desc"]],
			"columnDefs": [
				{"targets": 0, "className": "text-right"},
				{"targets": 3, "className": "text-right"},
				{"targets": 4, "className": "text-center"},
			<?php if($_SESSION["level"] == "gudang") { ?>
				{"targets": 7, "className": "text-right"},
				{"targets": 9, "orderable": false},
				{"targets": 9, "className": "hide_on_print"},
				{"targets": 10, "visible": false}
			<?php } else { ?>
				{"targets": 7, "className": "text-right"}
			<?php } ?>
			],
			"dom": "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
		$("#tanggal_masuk").datepicker({
			"format": "yyyy-mm-dd",
			"maxViewMode": 2,
			"container": "#dlg"
		});
	});
	<?php if($_SESSION["level"] == "gudang") { ?>
	function tambah() {
		$("#judul_modal").html("Tambah Data Barang");
		$("#nama_barang").val("");
		$("#kode_kategori").val("");
		$("#jumlah").val(0);
		$("#tanggal_masuk").datepicker("update", "<?php echo date("Y-m-d"); ?>");
		$("#nilai_barang").val(0);
		$("#negara_asal").val("");
		$("#satuan").val("");
		$("#mata_uang").val("");
		$(".selectpicker").selectpicker("refresh");
		$("#input_simpan").show();
		$("#input_update").hide();
		$("#dlg").modal("show");
	}
	
	function simpan() {
		var nama_barang = $("#nama_barang").val();
		var kode_kategori = $("#kode_kategori").val();
		var jumlah = $("#jumlah").val();
		var tanggal_masuk = $("#tanggal_masuk").val();
		var nilai_barang = $("#nilai_barang").val();
		var negara_asal = $("#negara_asal").val();
		var satuan = $("#satuan").val();
		var mata_uang = $("#mata_uang").val();
		
		if(isNaN(jumlah)) {
			BootstrapDialog.alert("Kolom <i>Jumlah</i> harus angka!");
			return;
		}
		
		if(isNaN(nilai_barang)) {
			BootstrapDialog.alert("Kolom <i>Nilai Barang</i> harus angka!");
			return;
		}
		
		if(nama_barang == "" || kode_kategori == "" || jumlah == "" || tanggal_masuk == "" || nilai_barang == "" || negara_asal == "" || satuan == "" || mata_uang == "") {
			BootstrapDialog.alert("Semua kolom harus terisi.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("barang_simpan.php", {"save": true, "nama_barang": nama_barang, "kode_kategori": kode_kategori, "jumlah": jumlah, "tanggal_masuk": tanggal_masuk, "nilai_barang": nilai_barang, "negara_asal": negara_asal, "satuan": satuan, "mata_uang": mata_uang}, function(data) {
			if(data === "berhasil") {
				$("#dlg").modal("hide");
				BootstrapDialog.alert("<i class='fa fa-check'></i> Berhasil menyimpan data.");
				TabelData.draw();
			} else {
				BootstrapDialog.alert(data);
			}
		}).fail(function() {
			BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menyimpan data. Server sedang bermasalah.");
		}).always(function() {
			$(".btn-loading").removeAttr("disabled");
			$(".close").show();
		});
	}
	
	function edit(baris) {
		var kolom = TabelData.row(baris).data();
		$("#judul_modal").html("Edit Data Barang");
		$("#kode_barang").val(kolom[0]);
		$("#nama_barang").val($("<div/>").html(kolom[1]).text());
		$("#kode_kategori").val(kolom[10][0]);
		$("#jumlah").val(kolom[10][1]);
		$("#tanggal_masuk").datepicker("update", kolom[4]);
		$("#nilai_barang").val(kolom[10][2]);
		$("#negara_asal").val($("<div/>").html(kolom[5]).text());
		$("#satuan").val($("<div/>").html(kolom[6]).text());
		$("#mata_uang").val($("<div/>").html(kolom[8]).text());
		$(".selectpicker").selectpicker("refresh");
		$("#input_simpan").hide();
		$("#input_update").show();
		$("#dlg").modal("show");
	}
	
	function update() {
		var kode_barang = $("#kode_barang").val();
		var nama_barang = $("#nama_barang").val();
		var kode_kategori = $("#kode_kategori").val();
		var jumlah = $("#jumlah").val();
		var tanggal_masuk = $("#tanggal_masuk").val();
		var nilai_barang = $("#nilai_barang").val();
		var negara_asal = $("#negara_asal").val();
		var satuan = $("#satuan").val();
		var mata_uang = $("#mata_uang").val();
		
		if(isNaN(jumlah)) {
			BootstrapDialog.alert("Kolom <i>Jumlah</i> harus angka!");
			return;
		}
		
		if(isNaN(nilai_barang)) {
			BootstrapDialog.alert("Kolom <i>Nilai Barang</i> harus angka!");
			return;
		}
		
		if(kode_barang == "" || nama_barang == "" || kode_kategori == "" || jumlah == "" || tanggal_masuk == "" || nilai_barang == "" || negara_asal == "" || satuan == "" || mata_uang == "") {
			BootstrapDialog.alert("Semua kolom harus terisi.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("barang_update.php", {"update": true, "kode_barang": kode_barang, "nama_barang": nama_barang, "kode_kategori": kode_kategori, "jumlah": jumlah, "tanggal_masuk": tanggal_masuk, "nilai_barang": nilai_barang, "negara_asal": negara_asal, "satuan": satuan, "mata_uang": mata_uang}, function(data) {
			if(data === "berhasil") {
				$("#dlg").modal("hide");
				BootstrapDialog.alert("<i class='fa fa-check'></i> Berhasil menyimpan data.");
				TabelData.draw(false);
			} else {
				BootstrapDialog.alert(data);
			}
		}).fail(function() {
			BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menyimpan data. Server sedang bermasalah.");
		}).always(function() {
			$(".btn-loading").removeAttr("disabled");
			$(".close").show();
		});
	}
	
	function hapus(baris) {
		var kolom = TabelData.row(baris).data();
		BootstrapDialog.show({
			"type": BootstrapDialog.TYPE_DANGER,
			"title": "<b><i class='fa fa-trash'></i>&nbsp;Hapus Barang</b>",
			"message": "Anda yakin ingin menghapus \"" + kolom[1] + "\"?",
			"closeByBackdrop": false,
			"closeByKeyboard": false,
			"buttons": [{
				"cssClass": "btn btn-default btn-hapus",
				"icon": "fa fa-trash",
				"label": "Hapus",
				"action": function(dialog) {
					dialog.setClosable(false);
					$(".btn-hapus").attr("disabled", "disabled");
					$.post("barang_delete.php", {"hapus": true, "kode_barang": kolom[0]}, function(data) {
						if(data === "berhasil") {
							BootstrapDialog.alert("<i class='fa fa-check'></i> Berhasil menghapus data.");
							TabelData.draw(false);
							dialog.close();
						} else {
							BootstrapDialog.alert(data);
						}
					}).fail(function() {
						BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menghapus data. Server sedang bermasalah.");
					}).always(function() {
					$(".btn-hapus").removeAttr("disabled");
						dialog.setClosable(true);
					});
				}
			},{
				"cssClass": "btn btn-default btn-hapus",
				"icon": "fa fa-times",
				"label": "Tutup",
				"action": function(dialog){    
					dialog.close();
				}
			}]
		});
	}
	<?php } ?>
	function print_laporan() {
		var tanggal = new Date();
		var hari = tanggal.getDate() < 10 ? "0" + tanggal.getDate() : tanggal.getDate();
		var bulan = (tanggal.getMonth() + 1) < 10 ? "0" + (tanggal.getMonth() + 1) : (tanggal.getMonth() + 1);
		var tahun = tanggal.getFullYear();
		var w = window.open("about:blank", "_blank");
		w.document.write("<title>Laporan Stok Barang</title><body style='padding:10px;'>");
		w.document.write("<link rel='stylesheet' href='../../template/assets/bootstrap/css/bootstrap.min.css'>");
		w.document.write("<style type='text/css'>th{text-align:center;}.hide_on_print{display:none !important;}</style>");
		w.document.write("<table style='width:100%;'><tr><td><img src='../../template/assets/images/logo_aplus.png'></td><td style='text-align:right;'>");
		w.document.write("Laporan Stok Barang di<br/><b>PT. APLUS PACIFIC</b><br/>Tanggal Cetak: "+hari+"/"+bulan+"/"+tahun+"</td></tr></table><br/>");
		w.document.write("<table class='table table-bordered table-striped' style='width:100%;'>");
		w.document.write($("#tabel").html() + "</table></body>");
		setTimeout(function() {
			w.print();
		}, 500);
	}
</script>
<?php
	include("../../template/footer.php");
}
?>