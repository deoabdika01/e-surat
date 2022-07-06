<?php
session_start();
if(empty($_SESSION)) {
	header("location:../../index.php");
} else {
	include("../../inc/koneksi.php");
	include("../../template/header.php");
	include("../../template/sidebar.php");
?>
<title>User</title>
<section class="content">
	<div class="box">
		<div class="col-xs-12">
			<h2 class="page-header">
				Data User
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
						<th>Username</th>
						<th>Nama User</th>
						<th style="width:100px;">Level</th>
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
				<h4 class="modal-title" id="judul_modal">Tambah Data User</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="kode_user">
				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control" id="username" placeholder="Nama User">
				</div>
				<div class='form-group'>
					<label>Nama User</label>
					<input type="text" class="form-control" id="nama_user" placeholder="Nama User">
				</div>
				<div class='form-group'>
					<label>Level User</label>
					<select class="form-control selectpicker" data-live-search="false" id="level_user" title="-- Pilih Level User --">
						<option value="" data-hidden="true"></option>
						<option value="1">Gudang</option>
						<option value="2">Pegawai</option>
						<option value="3">Biro Pengadaan</option>
						<option value="4">Manager</option>
					</select>
				</div>
				<div class='form-group'>
					<label>Password Baru:</label>
					<input type='password' class='form-control' placeholder='Masukkan password baru' id='input_password_baru'>
				</div>
				<div class='form-group'>
					<label>Konfirmasi Password Baru:</label>
					<input type='password' class='form-control' placeholder='Konfirmasi password baru' id='input_konfirmasi'>
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
				"url": "user_ambil.php",
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
				{"targets": 2, "className": "text-center"},
				{"targets": 3, "orderable": false},
				{"targets": 4, "visible": false}
			<?php } else { ?>
				{"targets": 2, "className": "text-center"}
			<?php } ?>
			],
			"dom": "<'row'<'col-sm-5'l><'col-sm-2'><'col-sm-5'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
	});
	<?php if($_SESSION["level"] == "gudang") { ?>
	function tambah() {
		$("#judul_modal").html("Tambah Data User");
		$("#username").val("");
		$("#nama_user").val("");
		$("#level_user").val("");
		$("#input_password_baru").val("");
		$("#input_konfirmasi").val("");
		$("#input_password_baru").attr("placeholder", "Masukkan password baru");
		$("#input_konfirmasi").attr("placeholder", "Konfirmasi password baru");
		$(".selectpicker").selectpicker("refresh");
		$("#input_simpan").show();
		$("#input_update").hide();
		$("#dlg").modal("show");
	}
	
	function simpan() {
		var username = $("#username").val();
		var nama_user = $("#nama_user").val();
		var level_user = $("#level_user").val();
		var password = $("#input_password_baru").val();
		var konfirmasi = $("#input_konfirmasi").val();
		
		if(username == "" || nama_user == "" || level_user == "" || password == "" || konfirmasi == "") {
			BootstrapDialog.alert("Semua kolom harus terisi.");
			return;
		}
		
		if(password !== konfirmasi) {
			BootstrapDialog.alert("Password tidak cocok.");
			return;
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("user_simpan.php", {"save": true, "username": username, "password": password, "nama_user": nama_user, "level_user": level_user}, function(data) {
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
		$("#judul_modal").html("Edit Data User");
		$("#kode_user").val(kolom[4][0]);
		$("#username").val($("<div/>").html(kolom[0]).text());
		$("#nama_user").val($("<div/>").html(kolom[1]).text());
		$("#level_user").val(kolom[4][1]);
		$("#input_password_baru").val("");
		$("#input_konfirmasi").val("");
		$("#input_password_baru").attr("placeholder", "Masukkan password baru (kosongi jika tidak diganti)");
		$("#input_konfirmasi").attr("placeholder", "Konfirmasi password baru (kosongi jika tidak diganti)");
		$(".selectpicker").selectpicker("refresh");
		$("#input_simpan").hide();
		$("#input_update").show();
		$("#dlg").modal("show");
	}
	
	function update() {
		var kode_user = $("#kode_user").val();
		var username = $("#username").val();
		var nama_user = $("#nama_user").val();
		var level_user = $("#level_user").val();
		var password = $("#input_password_baru").val();
		var konfirmasi = $("#input_konfirmasi").val();
		
		if(username == "" || nama_user == "" || level_user == "") {
			BootstrapDialog.alert("Semua kolom harus terisi kecuali kolom password.");
			return;
		}
		
		if(password != "" || konfirmasi != "") {
			if(password !== konfirmasi) {
				BootstrapDialog.alert("Password tidak cocok.");
				return;
			}
		}
		
		$(".close").hide();
		$(".btn-loading").attr("disabled", "disabled");
		$.post("user_update.php", {"update": true, "kode_user": kode_user, "username": username, "password": password, "nama_user": nama_user, "level_user": level_user}, function(data) {
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
			"title": "<b><i class='fa fa-trash'></i>&nbsp;Hapus User</b>",
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
					$.post("user_delete.php", {"hapus": true, "kode_user": kolom[4][0]}, function(data) {
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