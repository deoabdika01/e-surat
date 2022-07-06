<?php
  include ('../../config/koneksi.php');
  include ('../part/header.php');
  
?>


<div class="content-wrapper">
  <section class="content-header">
    <h1>StatusSurat</h1>
    
  </section>
  <section class="content">      
    <div class="row">
      <div class="col-md-12">
        <br><br>
        <table class="table table-striped table-bordered table-responsive" id="data-table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th><strong>Tanggal</strong></th>
              <th><strong>NIK</strong></th>
              <th><strong>Nama</strong></th>
              <th><strong>Jenis Surat</strong></th>
              <th><strong>Status</strong></th>
              
            </tr>
          </thead>
          <tbody>
            <?php
           
               
              $qTampil = mysqli_query($connect, "SELECT penduduk.nama, surat_keterangan.id_sk, surat_keterangan.no_surat, surat_keterangan.nik, surat_keterangan.jenis_surat, surat_keterangan.status_surat, surat_keterangan.tanggal_surat FROM penduduk LEFT JOIN surat_keterangan ON surat_keterangan.nik = penduduk.nik  
                UNION SELECT penduduk.nama, surat_keterangan_berkelakuan_baik.id_skbb, surat_keterangan_berkelakuan_baik.no_surat, surat_keterangan_berkelakuan_baik.nik, surat_keterangan_berkelakuan_baik.jenis_surat, surat_keterangan_berkelakuan_baik.status_surat, surat_keterangan_berkelakuan_baik.tanggal_surat FROM penduduk LEFT JOIN surat_keterangan_berkelakuan_baik ON surat_keterangan_berkelakuan_baik.nik = penduduk.nik 
                UNION SELECT penduduk.nama, surat_keterangan_domisili.id_skd, surat_keterangan_domisili.no_surat, surat_keterangan_domisili.nik, surat_keterangan_domisili.jenis_surat, surat_keterangan_domisili.status_surat, surat_keterangan_domisili.tanggal_surat FROM penduduk LEFT JOIN surat_keterangan_domisili ON surat_keterangan_domisili.nik = penduduk.nik 
                UNION SELECT penduduk.nama, surat_keterangan_kepemilikan_kendaraan_bermotor.id_skkkb, surat_keterangan_kepemilikan_kendaraan_bermotor.no_surat, surat_keterangan_kepemilikan_kendaraan_bermotor.nik, surat_keterangan_kepemilikan_kendaraan_bermotor.jenis_surat, surat_keterangan_kepemilikan_kendaraan_bermotor.status_surat, surat_keterangan_kepemilikan_kendaraan_bermotor.tanggal_surat FROM penduduk LEFT JOIN surat_keterangan_kepemilikan_kendaraan_bermotor ON surat_keterangan_kepemilikan_kendaraan_bermotor.nik = penduduk.nik 
                UNION SELECT penduduk.nama, surat_keterangan_perhiasan.id_skp, surat_keterangan_perhiasan.no_surat, surat_keterangan_perhiasan.nik, surat_keterangan_perhiasan.jenis_surat, surat_keterangan_perhiasan.status_surat, surat_keterangan_perhiasan.tanggal_surat FROM penduduk LEFT JOIN surat_keterangan_perhiasan ON surat_keterangan_perhiasan.nik = penduduk.nik 
                UNION SELECT penduduk.nama, surat_lapor_hajatan.id_slh, surat_lapor_hajatan.no_surat, surat_lapor_hajatan.nik, surat_lapor_hajatan.jenis_surat, surat_lapor_hajatan.status_surat, surat_lapor_hajatan.tanggal_surat FROM penduduk LEFT JOIN surat_lapor_hajatan ON surat_lapor_hajatan.nik = penduduk.nik 
                UNION SELECT penduduk.nama, surat_pengantar_skck.id_sps, surat_pengantar_skck.no_surat, surat_pengantar_skck.nik, surat_pengantar_skck.jenis_surat, surat_pengantar_skck.status_surat, surat_pengantar_skck.tanggal_surat FROM penduduk LEFT JOIN surat_pengantar_skck ON surat_pengantar_skck.nik = penduduk.nik ");
               
               while ($row = @mysqli_fetch_array($qTampil)){
                 if(!empty($row['nik'])){
                  if($row['nik'] == $_SESSION['nik']){
                 
            ?>
                    <tr>
                      <?php
                        $tgl_lhr = date($row['tanggal_surat']);
                        $tgl = date('d ', strtotime($tgl_lhr));
                        $bln = date('F', strtotime($tgl_lhr));
                        $thn = date(' Y', strtotime($tgl_lhr));
                        $blnIndo = array(
                            'January' => 'Januari',
                            'February' => 'Februari',
                            'March' => 'Maret',
                            'April' => 'April',
                            'May' => 'Mei',
                            'June' => 'Juni',
                            'July' => 'Juli',
                            'August' => 'Agustus',
                            'September' => 'September',
                            'October' => 'Oktober',
                            'November' => 'November',
                            'December' => 'Desember'
                        );
                      ?>
                      <td><?php echo $tgl . $blnIndo[$bln] . $thn; ?></td>
                      <td><?php echo $row['nik']; ?></td>
                      <td style="text-transform: capitalize;"><?php echo $row['nama']; ?></td>
                      <td><?php echo $row['jenis_surat']; ?></td>
                      <td>
                        <?php 
                            If($row['status_surat'] == 'SELESAI'){
                        ?> 
                      <a class="btn btn-success btn-sm" href='#'><i class="fa fa-spinner"></i><b> <?php echo $row['status_surat']; ?></b></a></td>
                      <?php 
                            } else{
                        ?> 
                         <a class="btn btn-danger btn-sm" href='#'><i class="fa fa-spinner"></i><b> <?php echo $row['status_surat']; ?></b></a></td>
                         <?php 
                            } 
                        ?>  
                    </tr>
                   
            <?php 
                  }
                 }
                }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<?php 
  include ('../part/footer.php');
?>