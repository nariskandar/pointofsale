<?php
session_start();
// START
error_reporting(E_ALL ^ E_DEPRECATED );
include "../../configuration/config_etc.php";
include "../../configuration/config_include.php";
include "../../configuration/config_chmod.php";


$halaman = "barang"; // halaman
$dataapa = "Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu4; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['scan'];

$page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

if ($page <= 0)
    $page = 1;
$rpp = 10;
$decimal ="0";
$a_decimal =",";
$thousand =".";

$count   = 0;
$i       = ($page - 1) * $rpp;
$no_urut = ($page - 1) * $rpp;
?>

    <table id="tampil" class="table table-hover ">
        <thead>
            <tr>
                <th>No</th>
                <th>SKU</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Isi per Kemasan</th>
                <th>Stok Eceran</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Merek</th>
                <?php	if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                <th>Opsi</th>
                <?php }else{} ?>
            </tr>
        </thead>


<?php
// if ($search != null || $search != "") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['scan'])) {
                $query1 = "SELECT *,barang.no as no,barang.kode as kode, barang.nama as nama, kategori.nama as kategori, satuan.nama as satuan, brand.nama as brand FROM  $forward inner join kategori on kategori.kode = barang.kategori inner join satuan on satuan.kode = barang.satuan inner join brand on brand.kode = barang.brand where barang.barcode like '%$search%' or barang.kode like '%$search%' or barang.nama like '%$search%' order by barang.no limit $rpp";
				$hasil = mysqli_query($conn,$query1);
                $no = 1;
                // var_dump($hasil);
                if($hasil->num_rows > 0) {
                while ($fill = mysqli_fetch_assoc($hasil)) {
                    ?>
        <tbody>
            <tr>
                <td><?php echo ++$no_urut;?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['satuan']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['hargabeli'], $decimal, $a_decimal, $thousand).',-'); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, number_format($fill['hargajual'], $decimal, $a_decimal, $thousand).',-'); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['isipersatuan']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['stokeceran']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['keterangan']); ?></td>
                <td><?php  echo mysqli_real_escape_string($conn, $fill['brand']); ?></td>
                <td><?php  if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
					<button type="button" class="btn btn-success btn-xs" onclick="window.location.href='edit_<?php echo $halaman;?>?no=<?php  echo $fill['no']; ?>'">Edit</button>
					 <?php } else {}?>

					 <?php	if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
					<button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
					 <?php } else {}?>
		    	</td>
            </tr>
        </tbody>
    <?php
                    } 
                } else {
                    $r_scan = $_POST['scan'];
                    ?>
                    <!-- Modal -->
<div id="myModal" class="modal show" role="dialog">
  <div class="modal-dialog" style="margin-top:130px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Barcode <b><?= $r_scan; ?></b> belum tersedia di katalog</h4>
      </div>
      <div class="modal-body">
        <p>Apakah anda akan menambahkan data barang ? </p>
      </div>
      <div class="modal-footer">
        <a href="barang.php" class="btn btn-default" role="button">Tidak</a>
        <a href="add_barang.php?r_scan=<?= $r_scan; ?>" class="btn btn-info" role="button">Iya, Tambah barang</a>
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Iya, tambah barang</button> -->
      </div>
    </div>

  </div>
</div>
                    <?php
                    // require "barang_modal.php";
                }
            } 
    } 
// } 

?>
</table>