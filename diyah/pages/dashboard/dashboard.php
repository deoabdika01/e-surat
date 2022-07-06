<?php
session_start();
if(empty($_SESSION)) {
	header("location:../../index.php");
} else {
	include("../../template/header.php");
	include("../../template/sidebar.php");
?>
<title>Dashboard</title>
<style type="text/css">
	div.content-wrapper {
		background-color : red;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	.stroke-text {
		color: #000000;
		text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;
	}
</style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<div class="stroke-text" style="font-size:24px;">Selamat Datang, <?php echo $_SESSION["nama"]; ?></div>
		<div class="stroke-text" style="font-size:18px;">Sistem Inventory Bahan Baku PT. APLUS PACIFIC</div>
    </section>

    <!-- Main content -->
    <section class="content">
		<center>
			<br/>
			<br/>
			<br/>
			<img src="../../template/assets/images/logo_aplus.png" style = "width:100px;height:50px;">
			<br/>
			<br/>
			<br/>
			<div class="stroke-text" style="font-size:24px;font-weight:bold;">PT. APLUS PACIFIC</div>
			<div class="stroke-text" style="font-size:20px;"><b>Office</b>: Jl. Veteran No. 11 Segoromadu Gresik 61123</div>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<div class="stroke-text" style="font-size:35px;font-weight:bold;">-= Bekerja Bersama untuk Membangun Negeri =-</div>
		</center>
    </section>
    <!-- /.content -->
<?php
	include("../../template/footer.php");
}
?>