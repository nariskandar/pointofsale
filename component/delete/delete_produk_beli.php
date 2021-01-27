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
  $sqle3="SELECT * FROM barang where barcode='$barang'";
  $hasile3=mysqli_query($conn,$sqle3);
  $row=mysqli_fetch_assoc($hasile3);
  $terjualawal=$row['terjual'];
  $sisa=$row['sisa'];
  $isipersatuan=$row['isipersatuan'];
  $stokeceranawal=$row['stokeceran'];


  $terjualakhir = $terjualawal-$jumlah;
  $sisaakhir = $sisa + $jumlah;

  $pengurangan = $jumlah * $isipersatuan;

  $stokeceran = $stokeceranawal + $pengurangan;

  $jmheceranbeli = $jumlah * $isipersatuan;
  $terbelieceran = $terbeliawaleceran - $jmheceranbeli;


   $sqll3 = "UPDATE barang SET terjual='$terjualakhir', sisa='$sisaakhir', stokeceran ='$stokeceran', stokeceranterbeli='$terbelieceran' where barcode='$barang'";
   
   $updatestok = mysqli_query($conn, $sqll3);
}else{
  $sqle3="SELECT * FROM barang where barcode='$barang'";
  $hasile3=mysqli_query($conn,$sqle3);
  $row=mysqli_fetch_assoc($hasile3);
  $sisaawal=$row['sisa'];
  $terbeliawal=$row['terbeli'];
  $terjualawal=$row['terjual'];
  $isipersatuan=$row['isipersatuan'];
  $stokeceranawal=$row['stokeceran'];

if($jumlah >= $terbeliawal){
  $terbeliakhir = $jumlah - $terbeliawal;
}else if($jumlah<= $terbeliawal){
    $terbeliakhir = $terbeliawal - $jumlah;
}
    $sisaakhir = $terbeliakhir - $terjualawal;

    $pengurangan = $jumlah * $isipersatuan;
    $stokeceran = $stokeceranawal - $pengurangan;    
    $terbelieceran = $terbeliakhir * $isipersatuan;

    
   $sql3 = "UPDATE barang SET terbeli='$terbeliakhir', sisa='$sisaakhir', stokeceran='$stokeceran', terbelieceran='$terbelieceran' where barcode='$barang'";
   $updatestok = mysqli_query($conn, $sql3);
//    var_dump($updatestok);
//    die;

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
