<?php
session_start();
if(empty($_SESSION)) {
	header("location:../../index.php");
} else {
	include("../../inc/koneksi.php");
	include("../../template/header.php");
	include("../../template/sidebar.php");
?>
<title>Transaksi</title>
<section class="content">
	<div class="box">
		<div class="col-xs-12">
			<h2 class="page-header">
				Data Transaksi
				<?php if($_SESSION["level"] != "biro_pengadaan") { ?>
				<small class="pull-right">
					<button class="btn btn-xs btn-primary" onclick="tambah();"><i class="fa fa-plus"></i> Add Data</button>
				</small>
				<?php } ?>
			</h2>
		</div>
		<div class="box-body">
			<table class="table table-bordered table-striped" style="width:100%;" id="tabel">
				<thead>
					<tr>
						<th>Kode Transaksi</th>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>User</th>
						<th>Quantity</th>
						<th>Tgl Transaksi</th>
						<?php if($_SESSION["level"] != "biro_pengadaan") { ?><th>Aksi</th><?php } ?>
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
				<h4 class="modal-title">Tambah Data Transaksi</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Barang</label>
					<select class="form-control selectpicker" data-live-search="true" id="kode_barang" title="-- Pilih Barang --">
						<option value='' data-hidden='true'></option>
						<?php
							$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY kode_barang DESC");
							while($row = mysqli_fetch_assoc($query)) {
								echo "<option value='".$row["kode_barang"]."'>".htmlspecialchars($row["nama_barang"])."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Quantity</label>
					<input type="number" class="form-control" id="quantity" min="0" value="0" placeholder="Quantity">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-info btn-loading" onclick="simpan();" id="input_simpan"><i class="fa fa-save"></i>&nbsp;Save</button>
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
				"url": "transaksi_ambil.php",
				"type": "POST"
			},
			"order": [[0, "desc"]],
			"columnDefs": [
				{"targets": 0, "className": "text-right"},
				{"targets": 1, "className": "text-right"},
				{"targets": 4, "className": "text-right"},
				{"targets": 5, "className": "text-center"}<?php if($_SESSION["level"] != "biro_pengadaan") { ?>, {"targets": 6, "orderable": false}<?php } ?>
			],
			"dom": "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
	});
	
	function tambah() {
		$("#kode_barang").val("");
		$("#quantity").val(0);
		$(".selectpicker").selectpicker("refresh");
		$("#dlg").modal("show");
	}
	
	function simpan() {
		var kode_barang = $("#kode_barang").val();
		var quantity = $("#quantity").val();
		
		if(kode_barang == "" || quantity == "") {
			BootstrapDialog.alert("Semua kolom harus terisi.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("transaksi_simpan.php", {"save": true, "kode_barang": kode_barang, "quantity": quantity}, function(data) {
			if(data.substr(0, 8) === "berhasil") {
				$("#dlg").modal("hide");
				BootstrapDialog.alert(data.substr(8, data.length));
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
			"title": "<b><i class='fa fa-trash'></i>&nbsp;Hapus Transaksi</b>",
			"message": "Anda yakin ingin menghapus transaksi barang \"" + kolom[2] + "\"?",
			"closeByBackdrop": false,
			"closeByKeyboard": false,
			"buttons": [{
				"cssClass": "btn btn-default btn-hapus",
				"icon": "fa fa-trash",
				"label": "Hapus",
				"action": function(dialog) {
					dialog.setClosable(false);
					$(".btn-hapus").attr("disabled", "disabled");
					$.post("transaksi_delete.php", {"hapus": true, "kode_transaksi": kolom[0]}, function(data) {
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
</script>
<?php
	include("../../template/footer.php");
}
?>