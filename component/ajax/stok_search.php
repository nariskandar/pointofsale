<?php
session_start();
// START
error_reporting(E_ALL ^ E_DEPRECATED );
include "../../configuration/config_etc.php";
include "../../configuration/config_include.php";
include "../../configuration/config_chmod.php";


$halaman = "stok_barang"; // halaman
$dataapa = "Stok Barang"; // data
$tabeldatabase = "barang"; // tabel database
$chmod = $chmenu8; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];

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
            <th>Kode Barang</th>
            <th>Nama barang</th>
            <th>Kategori</th>
            <th>Stok Terjual</th>
            <th>Stok Terbeli</th>
            <th>Sisa Stok Utuh</th>
            <th>Isi per Kemasan</th>
            <th>Stok Eceran</th>
            <th>H. beli X Stok</th>
        </tr>
    </thead>


<?php
// if ($search != null || $search != "") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['search'])){
            $query1="SELECT barang.kode AS kode,barang.nama AS nama, terjual, terbeli, sisa, deposit, stokeceran, kategori.nama AS kategori, isipersatuan, stokeceran, 	stokeceran - (sisa * isipersatuan) AS sisajualecer
            FROM $forward INNER JOIN kategori on kategori.kode = barang.kategori
            WHERE barang.barcode like '%$search%' or barang.nama like '%$search%' or kategori.nama like '%$search%' order by barang.no limit $rpp";
            $hasil = mysqli_query($conn,$query1);
            $no = 1;
            while ($fill = mysqli_fetch_assoc($hasil)){
              ?>
        <tbody>
        <tr>
        <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kategori']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['terjual']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['terbeli']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
            <?php if (mysqli_real_escape_string($conn, $fill['isipersatuan']) != "") : ?>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['isipersatuan']); ?></td>            
            <?php else :?>
            <td> - </td>
            <?php endif; ?>
            <?php if (mysqli_real_escape_string($conn, $fill['stokeceran']) != "") : ?>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['stokeceran']); ?></td>
            <?php else :?>
            <td> - </td>
            <?php endif; ?>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['deposit']); ?></td>
          </tr><?php
          ;
        }

        ?>
        </tbody>
                    <?php
                    // require "barang_modal.php";
                }
            } 
    // } 
// } 

?>
</table>