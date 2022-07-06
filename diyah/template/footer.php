</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        All rights reserved
    </div>
    <strong>Copyright &copy; Diyah Utami
</footer>
</div>
<!-- ./wrapper -->
</body>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").removeClass("hold-transition");
        window.setInterval(notification, 2000);
    });

    function notification() {
        $.ajax({
            url: '<?= $base_url ?>' + '../../pages/permintaan/permintaan_notif.php',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                var message = '';
                $.each(response.data, function (key, val) {
                    message += '<li>' +
                            '<a href="<?= $base_url ?>../../pages/permintaan/permintaan.php">' +
                            '<i class="fa fa-shopping-cart text-green"></i> Permintaan Barang ' + val.tanggal +
                            '</a>' +
                            '</li>';
                });
                $('#notif-list').html(message);
                $('#notif-count').html(response.count);
            }
        });
    }

    function read() {
        $.ajax({
            url: '<?= $base_url ?>' + '../../pages/permintaan/permintaan_notif_read.php',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                
            }
        });
    }
</script>
</html>