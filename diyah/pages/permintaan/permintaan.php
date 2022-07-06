<?php
session_start();
if (empty($_SESSION)) {
    header("location:../../index.php");
} else {
    include("../../inc/koneksi.php");
    include("../../template/header.php");
    include("../../template/sidebar.php");
    ?>
    <title>Permintaan Barang</title>
    <section class="content">
        <div class="box">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <?php echo $_SESSION["level"] == "pegawai" ? "Request Barang" : "Permintaan dari pegawai"; ?>
                    <?php if ($_SESSION["level"] == "pegawai") { ?>
                        <small class="pull-right">
                            <button class="btn btn-xs btn-primary" onclick="tambah();"><i class="fa fa-plus"></i> Add Data</button>
                        </small>
                    <?php } ?>
                    <small class="pull-right">
                        <button class="btn btn-xs btn-primary" onclick="print_laporan_all();"><i class="fa fa-print"></i> Print Laporan</button>
                    </small>
                </h2>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" style="width:100%;" id="tabel">
                    <thead>
                        <tr>
                            <th style="width:80px;">Tanggal</th>
                            <th>Nama Barang</th>
                            <th style="width:100px;">Jumlah</th>
                            <th style="width:80px;">Status</th>
                            <th>Diminta Oleh</th>
                            <th style="width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
    <?php if ($_SESSION["level"] == "pegawai") { ?>
        <div class="modal fade" id="dlg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <h4 class="modal-title" id="judul_modal">Tambah Request Barang</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="kode_permintaan">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" placeholder="Nama Barang">
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" min="0" value="0" placeholder="Jumlah">
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
    <?php } else { ?>
        <div class="modal fade" id="dlg_terima" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <h4 class="modal-title">Terima Permintaan</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" id="kode_permintaan_terima">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang_terima" placeholder="Nama Barang">
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control selectpicker" data-live-search="true" id="kode_kategori" title="-- Pilih Kode Kategori --">
                                        <option value='' data-hidden='true'></option>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY kategori ASC");
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            echo "<option value='" . $row["kode_kategori"] . "'>" . htmlspecialchars($row["kategori"]) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah_terima" min="0" value="0" placeholder="Jumlah">
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
                        <button class="btn btn-info btn-loading" onclick="simpan_terima();"><i class="fa fa-check-circle"></i>&nbsp;Terima</button>
                        <button class="btn btn-default btn-loading" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Batal</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
    $dari = date("d-m-Y", strtotime("-7 days", strtotime(date("d-m-Y"))));
    $sampai = date("d-m-Y");
    ?>
    <script type="text/javascript">
        var TabelData;
        $(document).ready(function () {
            TabelData = $("#tabel").DataTable({
                "processing": true,
                "serverSide": true,
                "searchDelay": 1000,
                "ajax": {
                    "url": "permintaan_ambil.php",
                    "type": "POST",
                    "data": function (d) {
                        var dari = $("#tgl_dari").val();
                        var sampai = $("#tgl_sampai").val();
                        if ($("#tanggal").html() == "") {
                            dari = "<?php echo $dari; ?>";
                            sampai = "<?php echo $sampai; ?>";
                        }
                        return $.extend({}, d, {"dari": dari, "sampai": sampai});
                    },
                },
                "drawCallback": function (settings) {
                    if (settings.aiDisplay.length > 0) {
                        $(".btn-tooltip").tooltip({"trigger": "hover"});
                    }
                },
                "order": [[0, "desc"]],
                "columnDefs": [
                    {"targets": 0, "className": "text-center"},
                    {"targets": 2, "className": "text-right"},
                    {"targets": 3, "className": "text-center"},
                    {"targets": 5, "orderable": false},
                    {"targets": 6, "visible": false}
                ],
                "dom": "<'row'<'col-sm-4'l><'col-sm-4'<'#tanggal'>><'col-sm-4'f>><'row'<'col-sm-12'<'table-responsive't>r>><'row'<'col-sm-5'i><'col-sm-7'p>>"
            });
            $("#tanggal").html("<center><div class='input-daterange input-group' style='width:270px;margin-bottom:5px;'>"
                    + "<input type='text' class='form-control input-sm' style='background-color:#fff;cursor:pointer;font-size:14px;width:100px;' id='tgl_dari' value='<?php echo $dari; ?>' readonly='readonly'>"
                    + "<span class='input-group-addon' style='width:70px;'>sampai</span>"
                    + "<input type='text' class='form-control input-sm' style='background-color:#fff;cursor:pointer;font-size:14px;width:100px;' id='tgl_sampai' value='<?php echo $sampai; ?>' readonly='readonly'>"
                    + "</div></center>"
                    );
            $(".input-daterange").datepicker({
                "format": "dd-mm-yyyy",
                "maxViewMode": 2,
                "autoclose": true
            }).on("changeDate", function (ev) {
                $("#tgl_dari").attr("disabled", "disabled");
                $("#tgl_sampai").attr("disabled", "disabled");
                TabelData.draw(false);
            });
    <?php if ($_SESSION["level"] != "pegawai") { ?>
                $("#tanggal_masuk").datepicker({
                    "format": "yyyy-mm-dd",
                    "maxViewMode": 2,
                    "container": "#dlg_terima"
                });
    <?php } ?>
        });
    <?php if ($_SESSION["level"] == "pegawai") { ?>
            function tambah() {
                $("#judul_modal").html("Tambah Request Barang");
                $("#nama_barang").val("");
                $("#jumlah").val(0);
                $("#input_simpan").show();
                $("#input_update").hide();
                $("#dlg").modal("show");
            }

            function simpan() {
                var nama_barang = $("#nama_barang").val();
                var jumlah = $("#jumlah").val();

                if (isNaN(jumlah)) {
                    BootstrapDialog.alert("Kolom <i>Jumlah</i> harus angka!");
                    return;
                }

                if (nama_barang == "" || jumlah == "") {
                    BootstrapDialog.alert("Semua kolom harus terisi.");
                    return;
                }

                $(".close").hide();
                $(".btn-loading").attr("disabled", "disabled");
                $.post("permintaan_simpan.php", {"save": true, "nama_barang": nama_barang, "jumlah": jumlah}, function (data) {
                    if (data === "berhasil") {
                        $("#dlg").modal("hide");
                        BootstrapDialog.alert("<i class='fa fa-check'></i>Berhasil menyimpan data.");
                        TabelData.draw();
                    } else {
                        BootstrapDialog.alert(data);
                    }
                }).fail(function () {
                    BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menyimpan data. Server sedang bermasalah.");
                }).always(function () {
                    $(".btn-loading").removeAttr("disabled");
                    $(".close").show();
                });
            }

            function edit(baris) {
                var kolom = TabelData.row(baris).data();
                if (kolom[6][2] != 0) {
                    var status_barang = "ditolak";
                    if (kolom[6][2] == 1) {
                        status_barang = "diterima";
                    }
                    BootstrapDialog.alert("<i class='fa fa-times'></i> Tidak bisa mengedit barang. Barang sudah " + status_barang + ".");
                    return;
                }
                $("#judul_modal").html("Edit Request Barang");
                $("#kode_permintaan").val(kolom[6][0]);
                $("#nama_barang").val($("<div/>").html(kolom[1]).text());
                $("#jumlah").val(kolom[6][1]);
                $("#input_simpan").hide();
                $("#input_update").show();
                $("#dlg").modal("show");
            }

            function update() {
                var kode_permintaan = $("#kode_permintaan").val();
                var nama_barang = $("#nama_barang").val();
                var jumlah = $("#jumlah").val();

                if (isNaN(jumlah)) {
                    BootstrapDialog.alert("Kolom <i>Jumlah</i> harus angka!");
                    return;
                }

                if (kode_permintaan == "" || nama_barang == "" || jumlah == "") {
                    BootstrapDialog.alert("Semua kolom harus terisi.");
                    return;
                }

                $(".close").hide();
                $(".btn-loading").attr("disabled", "disabled");
                $.post("permintaan_update.php", {"update": true, "kode_permintaan": kode_permintaan, "nama_barang": nama_barang, "jumlah": jumlah}, function (data) {
                    if (data === "berhasil") {
                        $("#dlg").modal("hide");
                        BootstrapDialog.alert("<i class='fa fa-check'></i>Berhasil menyimpan data.");
                        TabelData.draw(false);
                    } else {
                        BootstrapDialog.alert(data);
                    }
                }).fail(function () {
                    BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menyimpan data. Server sedang bermasalah.");
                }).always(function () {
                    $(".btn-loading").removeAttr("disabled");
                    $(".close").show();
                });
            }

            function hapus(baris) {
                var kolom = TabelData.row(baris).data();
                if (kolom[6][2] != 0) {
                    var status_barang = "ditolak";
                    if (kolom[6][2] == 1) {
                        status_barang = "diterima";
                    }
                    BootstrapDialog.alert("<i class='fa fa-times'></i> Tidak bisa menghapus barang. Barang sudah " + status_barang + ".");
                    return;
                }
                BootstrapDialog.show({
                    "type": BootstrapDialog.TYPE_DANGER,
                    "title": "<b><i class='fa fa-trash'></i>&nbsp;Hapus Permintaan</b>",
                    "message": "Anda yakin ingin menghapus permintaan \"" + kolom[1] + "\"?",
                    "closeByBackdrop": false,
                    "closeByKeyboard": false,
                    "buttons": [{
                            "cssClass": "btn btn-default btn-hapus",
                            "icon": "fa fa-trash",
                            "label": "Hapus",
                            "action": function (dialog) {
                                dialog.setClosable(false);
                                $(".btn-hapus").attr("disabled", "disabled");
                                $.post("permintaan_delete.php", {"hapus": true, "kode_permintaan": kolom[6][0]}, function (data) {
                                    if (data === "berhasil") {
                                        BootstrapDialog.alert("<i class='fa fa-check'></i> Berhasil menghapus data.");
                                        TabelData.draw(false);
                                        dialog.close();
                                    } else {
                                        BootstrapDialog.alert(data);
                                    }
                                }).fail(function () {
                                    BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menghapus data. Server sedang bermasalah.");
                                }).always(function () {
                                    $(".btn-hapus").removeAttr("disabled");
                                    dialog.setClosable(true);
                                });
                            }
                        }, {
                            "cssClass": "btn btn-default btn-hapus",
                            "icon": "fa fa-times",
                            "label": "Tutup",
                            "action": function (dialog) {
                                dialog.close();
                            }
                        }]
                });
            }
    <?php } else { ?>
            function terima(baris) {
                var kolom = TabelData.row(baris).data();
                $("#kode_permintaan_terima").val(kolom[6][0]);
                $("#nama_barang_terima").val($("<div/>").html(kolom[1]).text());
                $("#jumlah_terima").val(kolom[6][1]);
                $("#kode_kategori").val("");
                $("#tanggal_masuk").datepicker("update", "<?php echo date("Y-m-d"); ?>");
                $(".selectpicker").selectpicker("refresh");
                $("#dlg_terima").modal("show");
            }

            function simpan_terima() {
                var kode_permintaan = $("#kode_permintaan_terima").val();
                var nama_barang = $("#nama_barang_terima").val();
                var kode_kategori = $("#kode_kategori").val();
                var jumlah = $("#jumlah_terima").val();
                var tanggal_masuk = $("#tanggal_masuk").val();
                var nilai_barang = $("#nilai_barang").val();
                var negara_asal = $("#negara_asal").val();
                var satuan = $("#satuan").val();
                var mata_uang = $("#mata_uang").val();

                if (isNaN(jumlah)) {
                    BootstrapDialog.alert("Kolom <i>Jumlah</i> harus angka!");
                    return;
                }

                if (isNaN(nilai_barang)) {
                    BootstrapDialog.alert("Kolom <i>Nilai Barang</i> harus angka!");
                    return;
                }

                if (kode_permintaan == "" || nama_barang == "" || kode_kategori == "" || jumlah == "" || tanggal_masuk == "" || nilai_barang == "" || negara_asal == "" || satuan == "" || mata_uang == "") {
                    BootstrapDialog.alert("Semua kolom harus terisi.");
                    return;
                }

                $(".close").hide();
                $(".btn-loading").attr("disabled", "disabled");
                $.post("permintaan_terima.php", {"terima": true, "kode_permintaan": kode_permintaan, "nama_barang": nama_barang, "kode_kategori": kode_kategori, "jumlah": jumlah, "tanggal_masuk": tanggal_masuk, "nilai_barang": nilai_barang, "negara_asal": negara_asal, "satuan": satuan, "mata_uang": mata_uang}, function (data) {
                    if (data === "berhasil") {
                        $("#dlg_terima").modal("hide");
                        BootstrapDialog.alert("<i class='fa fa-check'></i> Berhasil menyimpan data.");
                        TabelData.draw(false);
                    } else {
                        BootstrapDialog.alert(data);
                    }
                }).fail(function () {
                    BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menyimpan data. Server sedang bermasalah.");
                }).always(function () {
                    $(".btn-loading").removeAttr("disabled");
                    $(".close").show();
                });
            }

            function tolak(baris) {
                var kolom = TabelData.row(baris).data();
                if (kolom[6][2] != 0) {
                    var status_barang = "ditolak";
                    if (kolom[6][2] == 1) {
                        status_barang = "diterima";
                    }
                    BootstrapDialog.alert("<i class='fa fa-times'></i> Tidak bisa menolak barang. Barang sudah " + status_barang + ".");
                    return;
                }
                BootstrapDialog.show({
                    "type": BootstrapDialog.TYPE_DANGER,
                    "title": "<b><i class='fa fa-times-circle'></i>&nbsp;Tolak Permintaan</b>",
                    "message": "Anda yakin ingin menolak permintaan barang \"" + kolom[1] + "\" dari \"" + kolom[4] + "\"?",
                    "closeByBackdrop": false,
                    "closeByKeyboard": false,
                    "buttons": [{
                            "cssClass": "btn btn-default btn-tolak",
                            "icon": "fa fa-times-circle",
                            "label": "Tolak",
                            "action": function (dialog) {
                                dialog.setClosable(false);
                                $(".btn-tolak").attr("disabled", "disabled");
                                $.post("permintaan_tolak.php", {"tolak": true, "kode_permintaan": kolom[6][0]}, function (data) {
                                    if (data === "berhasil") {
                                        BootstrapDialog.alert("<i class='fa fa-check'></i> Berhasil menyimpan data.");
                                        TabelData.draw(false);
                                        dialog.close();
                                    } else {
                                        BootstrapDialog.alert(data);
                                    }
                                }).fail(function () {
                                    BootstrapDialog.alert("<i class='fa fa-times'></i> Gagal menyimpan data. Server sedang bermasalah.");
                                }).always(function () {
                                    $(".btn-tolak").removeAttr("disabled");
                                    dialog.setClosable(true);
                                });
                            }
                        }, {
                            "cssClass": "btn btn-default btn-hapus",
                            "icon": "fa fa-times",
                            "label": "Tutup",
                            "action": function (dialog) {
                                dialog.close();
                            }
                        }]
                });
            }
            function print_laporan(baris) {
                var kolom = TabelData.row(baris).data();
                var tanggal_minta = kolom[0];
                var nama_barang = kolom[1];
                var jumlah_diminta = kolom[2];
                var nama_user = kolom[4];

                var tanggal = new Date();
                var hari = tanggal.getDate() < 10 ? "0" + tanggal.getDate() : tanggal.getDate();
                var bulan = (tanggal.getMonth() + 1) < 10 ? "0" + (tanggal.getMonth() + 1) : (tanggal.getMonth() + 1);
                var tahun = tanggal.getFullYear();

                var w = window.open("about:blank", "_blank");
                w.document.write("<title>Laporan Permintaan Barang</title><body style='padding:10px;'>");
                w.document.write("<link rel='stylesheet' href='../../template/assets/bootstrap/css/bootstrap.min.css'>");
                w.document.write("<style type='text/css'>th{text-align:center;}.hide_on_print{display:none !important;}</style>");
                w.document.write("<table style='width:100%;'><tr><td><img src='../../template/assets/images/logo_aplus.png'></td><td style='text-align:right;'>");
                w.document.write("Laporan Penerimaan Permintaan Barang di<br/><b>PT. APLUS PACIFIC</b><br/>Tanggal Cetak: " + hari + "/" + bulan + "/" + tahun + "</td></tr></table><br/>");
                w.document.write("<table cellspacing='8' cellpadding='0' border='0' style='width:100%;'>");
                w.document.write("<tr><td style='width:200px;'>Tanggal Request</td><td style='width:20px;'>:</td><td>" + tanggal_minta + "</td></tr>");
                w.document.write("<tr><td style='width:200px;'>Nama Barang</td><td style='width:20px;'>:</td><td>" + nama_barang + "</td></tr>");
                w.document.write("<tr><td style='width:200px;'>Jumlah</td><td style='width:20px;'>:</td><td>" + jumlah_diminta + "</td></tr>");
                w.document.write("<tr><td style='width:200px;'>Pengguna</td><td style='width:20px;'>:</td><td>" + nama_user + "</td></tr>");
                w.document.write("</table></body>");
                setTimeout(function () {
                    w.print();
                }, 500);
            }

            function print_laporan_all() {
                var tanggal = new Date();
                var hari = tanggal.getDate() < 10 ? "0" + tanggal.getDate() : tanggal.getDate();
                var bulan = (tanggal.getMonth() + 1) < 10 ? "0" + (tanggal.getMonth() + 1) : (tanggal.getMonth() + 1);
                var tahun = tanggal.getFullYear();
                var w = window.open("about:blank", "_blank");
                w.document.write("<title>Laporan Permintaan Barang</title><body style='padding:10px;'>");
                w.document.write("<link rel='stylesheet' href='../../template/assets/bootstrap/css/bootstrap.min.css'>");
                w.document.write("<style type='text/css'>th{text-align:center;}</style>");
                w.document.write("<table style='width:100%;'><tr><td><img src='../../template/assets/images/logo_aplus.png'></td><td style='text-align:right;'>");
                w.document.write("Laporan Permintaan Barang di<br/><b>PT. APLUS PACIFIC</b><br/>Tanggal Cetak: " + hari + "/" + bulan + "/" + tahun + "</td></tr></table><br/>");
                w.document.write("<table class='table table-bordered table-striped' style='width:100%;'>");
                w.document.write($("#tabel").html() + "</table></body>");
                setTimeout(function () {
                    w.print();
                }, 500);
            }
    <?php } ?>
    </script>
    <?php
    include("../../template/footer.php");
}
?>