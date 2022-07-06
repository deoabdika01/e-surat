<?php
session_start();
if(empty($_SESSION)) {
	header("location:../../index.php");
} else {
	include("../../inc/koneksi.php");
	include("../../template/header.php");
	include("../../template/sidebar.php");
?>
<title>Kategori</title>
<section class="content">
	<div class="box">
		<div class="col-xs-12">
			<h2 class="page-header">
				Data Kategori
				<?php if($_SESSION["level"] == "gudang") { ?>
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
						<th style="width:100px;">Kode Kategori</th>
						<th>Nama Kategori</th>
						<?php if($_SESSION["level"] == "gudang") { ?>
						<th style="width:100px;">Aksi</th>
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
				<h4 class="modal-title" id="judul_modal">Tambah Data Kategori</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="kode_kategori">
				<div class="form-group">
					<label>Nama Kategori</label>
					<input type="text" class="form-control" id="kategori" placeholder="Nama Kategori">
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
				"url": "kategori_ambil.php",
				"type": "POST"
			},
			"drawCallback": function(settings) {
				if(settings.aiDisplay.length > 0) {
					$(".btn-tooltip").tooltip({"trigger": "hover"});
				}
			},
			"order": [[0, "desc"]],
			"columnDefs": [
			<?php if($_SESSION["level"] == "gudang") { ?>
				{"targets": 0, "className": "text-right"},
				{"targets": 2, "orderable": false}
			<?php } else { ?>
				{"targets": 0, "className": "text-right"}
			<?php } ?>
			],
			"dom": "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
	});
	<?php if($_SESSION["level"] == "gudang") { ?>
	function tambah() {
		$("#judul_modal").html("Tambah Data Kategori");
		$("#kategori").val("");
		$("#input_simpan").show();
		$("#input_update").hide();
		$("#dlg").modal("show");
	}
	
	function simpan() {
		var kategori = $("#kategori").val();
		
		if(kategori == "") {
			BootstrapDialog.alert("Nama Kategori harus terisi.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("kategori_simpan.php", {"save": true, "kategori": kategori}, function(data) {
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
		$("#judul_modal").html("Edit Data Kategori");
		$("#kode_kategori").val(kolom[0]);
		$("#kategori").val($("<div/>").html(kolom[1]).text());
		$("#input_simpan").hide();
		$("#input_update").show();
		$("#dlg").modal("show");
	}
	
	function update() {
		var kode_kategori = $("#kode_kategori").val();
		var kategori = $("#kategori").val();
		
		if(kategori == "") {
			BootstrapDialog.alert("Nama Kategori harus terisi.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("kategori_update.php", {"update": true, "kode_kategori": kode_kategori, "kategori": kategori}, function(data) {
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
			"title": "<b><i class='fa fa-trash'></i>&nbsp;Hapus Kategori</b>",
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
					$.post("kategori_delete.php", {"hapus": true, "kode_kategori": kolom[0]}, function(data) {
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
</script>
<?php
	include("../../template/footer.php");
}
?>