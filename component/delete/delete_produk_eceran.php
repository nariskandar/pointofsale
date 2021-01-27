<?php
include "../../configuration/config_connect.php";
include "../../configuration/config_session.php";
include "../../configuration/config_chmod.php";
include "../../configuration/config_etc.php";
$forward =$_GET['forward'];
$no = $_GET['no'];
$chmod = $_GET['chmod'];
$forwardpage = $_GET['forwardpage'];
$kode = $_GET['kode'];
$jumlah = $_GET['jumlah'];
$barang = $_GET['barang'];
$get = $_GET['get'];
$detail = $_GET['detail'];
?>

<?php
if( $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] =='admin'){
if($get == '1'){
  $sqle3="SELECT barang.*, sisa * isipersatuan, stokeceran - (sisa * isipersatuan) AS sisajualecer FROM barang WHERE barcode ='$barang'";
  $hasile3=mysqli_query($conn,$sqle3);
  $row=mysqli_fetch_assoc($hasile3);
  $terjualawal=$row['terjual'];
  $sisa=$row['sisa'];
  $isipersatuan=$row['isipersatuan'];
  $stokeceranawal=$row['stokeceran'];
  $terjualawaleceran=$row['terjualeceran'];
  $terbelieceran=$row['terbelieceran'];
    
  $stokeceran = $stokeceranawal + $jumlah;

  $stokeceranterjual = $terbelieceran - $stokeceran;
 
  if ($stokeceran > $pengurangan) {
      $terjualsatuan = $terjualawal - 1;
      $sisasatuan = $sisa + 1;
      $sqll3 = "UPDATE barang SET terjual='$terjualsatuan', sisa='$sisasatuan', stokeceran ='$stokeceran', terjualeceran='$stokeceranterjual' where barcode='$barang'";
  } else {
    $sqll3 = "UPDATE barang SET terjualeceran='$stokeceranterjual', stokeceran ='$stokeceran' where barcode='$barang'";
  }


   $updatestok = mysqli_query($conn, $sqll3);
}else{
  $sqle3="SELECT * FROM barang where barcode='$barang'";
  $hasile3=mysqli_query($conn,$sqle3);
  $row=mysqli_fetch_assoc($hasile3);
  $sisaawal=$row['sisa'];
  $terbeliawal=$row['terbeli'];
  $terjualawal=$row['terjual'];
  $stokeceranawal=$row['stokeceran'];
  $isipersatuan=$row['isipersatuan'];

if($jumlah >= $terbeliawal){
  $terbeliakhir = $jumlah - $terbeliawal;
}else if($jumlah<= $terbeliawal){
    $terbeliakhir = $terbeliawal - $jumlah;
}
  $sisaakhir = $terbeliakhir - $terjualawal;
  $stokeceran = $sisaakhir * $isipersatuan;
  $terbelieceran = $sisaakhir * $isipersatuan;
  // var_dump($sisaakhir);
  // var_dump($stokeceran);
  // var_dump($terbelieceran);
  // die;

   $sql3 = "UPDATE barang SET
  terbeli='$terbeliakhir',
  sisa='$sisaakhir',
  terbelieceran='$terbelieceran',
  stokeceran='$stokeceran'
  where barcode='$barang'";
   $updatestok = mysqli_query($conn, $sql3);

}

 $sql = "delete from $forward where no='".$no."'";
 if (mysqli_query($conn, $sql)) {
 

 ?>

  <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
  <form action="<?php echo $baseurl; ?>/<?php echo $forwardpage;?>" name="frm1" method="post">

  <input type="hidden" name="kode" value="<?php echo $kode;?>" />
  <input type="hidden" name="hapusberhasil" value="1" />

<?php
 } else{
 ?>   <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
   <input type="hidden" name="kode" value="<?php echo $kode;?>" />
	  <input type="hidden" name="hapusberhasil" value="2" />
 <?php
 }


}else{

 ?>
  <body onload="setTimeout(function() { document.frm1.submit() }, 10)">
   <form action="<?php echo $baseurl; ?>/<?php echo $forwardpage;?>" name="frm1" method="post">

<input type="hidden" name="kode" value="<?php echo $kode;?>" />
	  <input type="hidden" name="hapusberhasil" value="2" />
 <?php
 }
?>
<table width="100%" align="center" cellspacing="0">
  <tr>
    <td height="500px" align="center" valign="middle"><img src="../../dist/img/load.gif">
  </tr>
</table>


   </form>
<meta http-equiv="refresh" content="10;url=jump?kode=<?php echo $kode.'&';?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo $forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>">
</body>
