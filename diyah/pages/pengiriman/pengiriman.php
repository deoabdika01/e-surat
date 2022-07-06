<?php
session_start();
if (empty($_SESSION)) {
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
                    Laporan Pengiriman Barang
                    <small class="pull-right">
                        <button class="btn btn-xs btn-primary" onclick="print_laporan();"><i class="fa fa-print"></i> Print Laporan</button>
                    </small>
                </h2>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" style="width:100%;" id="tabel">
                    <thead>
                        <tr>
                            <th style='width:100px;'>Tanggal</th>
                            <th style='width:100px;'>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th style='width:100px;'>Terkirim</th>
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
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<option value='" . $row["kode_barang"] . "'>" . htmlspecialchars($row["nama_barang"]) . "</option>";
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
                    "url": "pengiriman_ambil.php",
                    "data": function (d) {
                        var dari = $("#tgl_dari").val();
                        var sampai = $("#tgl_sampai").val();
                        if ($("#tanggal").html() == "") {
                            dari = "<?php echo $dari; ?>";
                            sampai = "<?php echo $sampai; ?>";
                        }
                        return $.extend({}, d, {"dari": dari, "sampai": sampai});
                    },
                    "type": "POST"
                },
                "drawCallback": function () {
                    $("#tgl_dari").removeAttr("disabled");
                    $("#tgl_sampai").removeAttr("disabled");
                },
                "order": [[0, "desc"]],
                "columnDefs": [
                    {"targets": 0, "className": "text-center"},
                    {"targets": 1, "className": "text-right"},
                    {"targets": 3, "className": "text-right"}
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
        });

        function print_laporan() {
            var tanggal = new Date();
            var hari = tanggal.getDate() < 10 ? "0" + tanggal.getDate() : tanggal.getDate();
            var bulan = (tanggal.getMonth() + 1) < 10 ? "0" + (tanggal.getMonth() + 1) : (tanggal.getMonth() + 1);
            var tahun = tanggal.getFullYear();
            var w = window.open("about:blank", "_blank");
            w.document.write("<title>Laporan Pengiriman Barang</title><body style='padding:10px;'>");
            w.document.write("<link rel='stylesheet' href='../../template/assets/bootstrap/css/bootstrap.min.css'>");
            w.document.write("<style type='text/css'>th{text-align:center;}</style>");
            w.document.write("<table style='width:100%;'><tr><td><img src='../../template/assets/images/logo_aplus.png'></td><td style='text-align:right;'>");
            w.document.write("Laporan Pengiriman Barang di<br/><b>PT. APLUS PACIFIC</b><br/>Tanggal Cetak: " + hari + "/" + bulan + "/" + tahun + "</td></tr></table><br/>");
            w.document.write("<table class='table table-bordered table-striped' style='width:100%;'>");
            w.document.write($("#tabel").html() + "</table></body>");
            setTimeout(function () {
                w.print();
            }, 500);
        }
    </script>
    <?php
    include("../../template/footer.php");
}
?>