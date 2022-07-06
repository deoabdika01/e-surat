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
				<?php if($_SESSION["level"] == "supplier" || $_SESSION["level"] == "biro_pengadaan" || $_SESSION["level"] == "manager") { ?>
				<small class="pull-right">
					<?php if($_SESSION["level"] == "supplier") { ?>
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
						<th>Kode Suppleir</th>
						<th>Nomor</th>
						<th>Tanggal Masuk</th>
						<th>Nopol</th>
						<th>Nama Perusahaan</th>
						<th>Alamat</th>
						<th>Nama Barang</th>
						<th>Banyak</th>
						<?php if($_SESSION["level"] == "supplier") { ?>
						<th>Aksi</th>
						<?php } ?>
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
				<input type="hidden" id="kode_supplier">
				<div class="row">
				<div class="col-md-6">
                        <div class="form-group">
							<label>Nomor</label>
							<input type="text" class="form-control" id="nomor" placeholder="Nomor">
						</div>
						<div class="form-group">
							<label>Tanggal Masuk</label>
							<input type="text" class="form-control" id="tanggal_masuk" value="<?php echo date("Y-m-d"); ?>" readonly="readonly" style="background-color:#fff;cursor:pointer;">
						</div>
						<div class="form-group">
							<label>NoPOL</label>
							<input type="text" class="form-control" id="nopol" placeholder="Nopol">
						</div>
						<div class="form-group">
							<label>Nama Perusahaan</label>
							<input type="text" class="form-control" id="nama_perusahaan" placeholder="Nama Perusahaan">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Alamat</label>
							<input type="text" class="form-control" id="alamat" placeholder="Alamat">
						</div>
						<div class="form-group">
							<label>Nama Barang</label>
							<input type="text" class="form-control" id="nama_barang" placeholder="Nama Barang">
						</div>
						<div class="form-group">
							<label>Banyak</label>
							<input type="number" class="form-control" id="banyak" min="0" value="0" placeholder="Banyak">
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
				"url": "supplier_ambil.php",
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
			<?php if($_SESSION["level"] == "supplir") { ?>
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
	<?php if($_SESSION["level"] == "supplier") { ?>
		function tambah() {
		$("#judul_modal").html("Tambah Data Supplier");
		$("#nomor").val("");
		$("#tanggal_masuk").datepicker("update", "<?php echo date("Y-m-d"); ?>");
		$("#nopol").val("");
		$("#nama_perusahaan").val("");
		$("#alamat").val("");
		$("#nama_barang").val("");
		$("#banyak").val(0);
		
		$(".selectpicker").selectpicker("refresh");
		$("#input_simpan").show();
		$("#input_update").hide();
		$("#dlg").modal("show");
	}
	
	function simpan() {
		var nomor = $("#nomor").val();
		var tanggal_masuk = $("#tanggal_masuk").val();
		var nopol = $("#nopol").val();
		var nama_perusahaan = $("#nama_perusahaan").val();
		var alamat = $("#alamat").val();
		var nama_barang = $("#nama_barang").val();
		var banyak = $("#banyak").val();
	
		
		if(isNaN(banyak)) {
			BootstrapDialog.alert("Kolom <i>Banyak</i> harus angka!");
			return;
		}
		

		if(nomor == "" || tanggal_masuk == "" || nopol == "" || nama_perusahaan == "" || alamat == "" || nama_barang == "" || banyak == "" ) {
			BootstrapDialog.alert("Semua kolom harus terisi.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("supplier_simpan.php", {"save": true, "nomor": nomor, "tanggal_masuk": tanggal_masuk, "nopol": nopol, "nama_perusahaan": nama_perusahaan, "alamat": alamat, "nama_barang": nama_barang, "banyak": banyak}, function(data) {
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
		$("#kode_supplier").val(kolom[1]);
		$("#nomor").val($("<div/>").html(kolom[1]).text());
		$("#tanggal_masuk").datepicker("update", kolom[2]);
		$("#nopol").val(kolom[3]);
		$("#nama_perusahaan").val(kolom[4]);
		$("#alamat").val(kolom[5]);
		$("#nama_barang").val(kolom[6]);
		$("#banyak").val(kolom[7]);
		$(".selectpicker").selectpicker("refresh");
		$("#input_simpan").hide();
		$("#input_update").show();
		$("#dlg").modal("show");
	}
	
	function update() {
		var kode_supplier=$("#kode_supplier").val();
		var nomor = $("#nomor").val();
		var tanggal_masuk = $("#tanggal_masuk").val();
		var nopol = $("#nopol").val();
		var nama_perusahaan = $("#nama_perusahaan").val();
		var alamat = $("#alamat").val();
		var nama_barang = $("#nama_barang").val();
		var banyak = $("#banyak").val();
	
		
		if(isNaN(banyak)) {
			BootstrapDialog.alert("Kolom <i>Banyak</i> harus angka!");
			return;
		}
		

		if(kode_supplier="" ||nomor == "" || tanggal_masuk == "" || nopol == "" || nama_perusahaan == "" || alamat == "" || nama_barang == "" || banyak == "" ) {
			BootstrapDialog.alert("Semua kolom harus terisi.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("supplier_update.php", {"update": true, "kode_supplier":kode_supplier,"nomor": nomor, "tanggal_masuk": tanggal_masuk, "nopol": nopol, "nama_perusahaan": nama_perusahaan, "alamat": alamat, "nama_barang": nama_barang, "banyak": banyak}, function(data) {
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