<?php
session_start();
// START
error_reporting(E_ALL ^ E_DEPRECATED );
include "../../configuration/config_etc.php";
include "../../configuration/config_include.php";
include "../../configuration/config_chmod.php";


$halaman = "satuan"; // halaman
$dataapa = "satuan"; // data
$tabeldatabase = "satuan"; // tabel database
$chmod = $chmenu11; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];

$sql    = "select * from $forward order by no";
$result = mysqli_query($conn, $sql);
$rpp    = 15;
$reload = "$halaman"."?pagination=true";
$page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

if ($page <= 0)
    $page = 1;
$tcount  = mysqli_num_rows($result);
$tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
$count   = 0;
$i       = ($page - 1) * $rpp;
$no_urut = ($page - 1) * $rpp;

?>

<table id="tampil" class="table table-hover ">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
    <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
            <th>Opsi</th>
    <?php }else{} ?>
        </tr>
    </thead>

    <?php

    $search = $_POST['search'];



        if ($_SERVER["REQUEST_METHOD"] == "POST") {

              if(isset($_POST['search'])){
        $query1="SELECT * FROM  $forward where kode like '%$search%' or nama like '%$search%' order by no limit $rpp";
        $hasil = mysqli_query($conn,$query1);
        $no = 1;
        while ($fill = mysqli_fetch_assoc($hasil)){
          ?>
                     <tbody>
<tr>
            <td><?php echo ++$no_urut;?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
            <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
            <td>
            <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
          <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='add_<?php echo $halaman;?>?no=<?php  echo $fill['no']; ?>'">Edit</button>
           <?php } else {}?>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
          <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_master?no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
           <?php } else {}?>
              </td></tr><?php
          ;
        }

        ?>
                  </tbody></table>

                  <?php
      }


  } else {
      while (($count<$rpp) && ($i<$tcount)) {
          mysqli_data_seek($result, $i);
          $fill = mysqli_fetch_array($result);
      }
  }
      ?>