<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
	  <div class="user-panel">
        <div>
          <center><a href="../../pages/profile/profile.php"><img src="../../template/assets/images/foto-profil/<?php echo $_SESSION["foto"]; ?>" style="width:80px;height:80px;border:3px solid white;" class="img-circle" alt="User Image" id="foto_di_sidebar"></a></center>
        </div>
        <div style="font-size:16px;color:#fff;margin:8px 0px 8px 0px;">
          <center><p>Admin <?php echo $_SESSION["level"] == "biro_pengadaan" ? "Biro Pengadaan" : ucfirst($_SESSION["level"]); ?></p></center>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MENU UTAMA</li>
		<?php if($_SESSION["level"] == "supplier") { ?>
		<li>
          <a style="font-size:20px;" href="../../pages/supplier/supplier.php">
            <i class="fa fa-th fa-fw"></i>&nbsp;&nbsp;<span>Suplier</span>
          </a>
        </li>
	<?php } ?>
	<?php if($_SESSION["level"] == "supplier" || $_SESSION["level"] || "petugas_gudang" ) { ?>
		<li>
          <a style="font-size:20px;" href="../../pages/barang/barang.php">
            <i class="fa fa-truck fa-fw"></i>&nbsp;&nbsp;<span>Data Barang</span>
          </a>
        </li>
	<?php } ?>
	<?php if($_SESSION["level"] == "petugas_gudang" || $_SESSION["level"] == "quality_control") { ?>
		<li>
          <a style="font-size:20px;" href="../../pages/Transaksi/Transaksi.php">
            <i class="fa fa-money fa-fw"></i>&nbsp;&nbsp;<span>Data Kulitas</span>
          </a>
        </li>
	<?php } ?>
	
	<?php if($_SESSION["level"] == "quality_control") { ?>
		<li>
          <a style="font-size:20px;" href="../../pages/user/user.php">
            <i class="fa fa-users fa-fw"></i>&nbsp;&nbsp;<span>Kualitas Bagus</span>
          </a>
        </li>
	<?php } ?>
	<?php if($_SESSION["level"] == "quality_control") { ?>
		  <li>
          <a style="font-size:20px;" href="../../pages/permintaan/permintaan.php">
            <i class="fa fa-cart-plus fa-fw"></i>&nbsp;&nbsp;<span>Kualitas Jelek</span>
          </a>
      </li>
	<?php } ?>
	<?php if($_SESSION["level"] == "gudang" || $_SESSION["level"] == "biro_pengadaan" || $_SESSION["level"] == "manager") { ?>
        <li class="treeview">
          <a style="font-size:20px;" href="#">
            <i class="fa fa-dashboard fa-fw"></i>&nbsp;&nbsp;<span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right fa-fw"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a style="font-size:14px;" href="../../pages/permintaan/permintaan.php"><i class="fa fa-circle-o fa-fw"></i> Permintaan dari Pegawai</a></li>
			<?php if($_SESSION["level"] == "biro_pengadaan") { ?><li><a style="font-size:14px;" href="../../pages/barang/barang.php"><i class="fa fa-circle-o fa-fw"></i> Laporan stok barang</a></li><?php } ?>
            <li><a style="font-size:14px;" href="../../pages/pengiriman/pengiriman.php"><i class="fa fa-circle-o fa-fw"></i> Laporan pengiriman barang</a></li>
		  </ul>
        </li>
	<?php } ?>
        
         
            
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">