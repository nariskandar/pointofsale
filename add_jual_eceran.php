<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
// include "interval.php";

etc();encryption();session();connect();head();body();timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
<meta http-equiv="refresh" content="0; url=logout" />
<?php
exit(0);
}
?>
        <div class="wrapper">
<?php
theader();
menu();
?>
            <div class="content-wrapper">
                <section class="content-header">
</section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
            <div class="col-lg-12">
<!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "configuration/config_chmod.php";
$halaman = "jual_eceran"; // halaman
$dataapa = "Penjualan"; // data
$tabeldatabase = "transaksimasuk"; // tabel database
$chmod = $chmenu6; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT (RIGHT(nota, 5)) as max_id FROM bayar ORDER BY no DESC LIMIT 0, 1";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_array($result);
  $id_max = $data['max_id'];
  $sort_num = (int) substr($id_max, 1, 5);
  $sort_num++;
  $new_code = sprintf("%05s", $sort_num);
  return $new_code;
 }
 
?>

<?php
$decimal ="0";
$a_decimal =",";
$thousand =".";
?>


<style>

#barang-list {
  float: left;
  list-style: none;
  margin-top: -3px;
  padding: 0;
  width: 190px;
  position: absolute;
}

#barang-list li {
  padding: 10px;
  background: #f0f0f0;
  border-bottom: #bbb9b9 1px solid;
}

#barang-list li:hover {
  background: #ece3d2;
  cursor: pointer;
}


</style>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
<script>
window.onload = function() {
  barang.value = "";
}

function jump001(field, autoMove) {
  // console.log(field.value.length);
  if (field.value.length >= field.maxLength) {
    document.getElementById(autoMove).focus();
  }
}


</script>

<script src="shortcuts.js"></script>
<script>
  function SubmitForm() {
    var kode = $("#kode").val();
    var barang = $("#barang").val();
    var nama = $("#nama").val();
    var hargajual = $("#hargajual").val();
    var hargabeli = $("#hargabeli").val();
    var jumlah = $("#jumlah").val();
    var hargaakhir = $("#hargaakhir").val();
    var stok = $("#stok").val();
    var datatotal = $("#datatotal").val();
    var isipersatuan = $("#isipersatuan").val();
    
    var hargabeliakhir = Math.round(hargabeli / isipersatuan);

    console.log(hargabeliakhir);
    console.log(isipersatuan);

    if (nama == "") {
      event.preventDefault();
    } else {
      if (stok == "0" || stok == "") {
        alertify.alert('Peringatan', 'Stok telah habis!', function () {});
        event.preventDefault();
      } else if (hargajual == "0") {
        alertify.alert('Peringatan', 'Harga satuan tidak boleh kosong!', function () {});
        event.preventDefault();
      } else if (hargabeli == "0" || hargabeli == ""){
        alertify.alert('Peringatan', 'Harga beli masih kosong, mohon untuk di isi!', function () {});
        event.preventDefault();        
      } else if(hargajual < hargabeliakhir){
        alertify.alert('Peringatan', 'Harga beli lebih besar dari harga Jual! <br> Harga Beli Barang ' + nama + ': Rp.' + hargabeliakhir, function () {});
        event.preventDefault();        
      } else if (jumlah == "") {
        alertify.alert('Peringatan', 'Jumlah kuantitas tidak boleh kosong!', function () {});
        event.preventDefault();
      }
      
    }
     

    $.post("add_jual.php", {
      kode: kode,
      barang: barang,
      nama: nama,
      hargajual: hargajual,
      hargabeli: hargabeli,
      jumlah: jumlah,
      hargaakhir: hargaakhir,
      isipersatuan : isipersatuan,
      stok : stok
    }, function (data) {

    });


  }
</script>

<!-- BOX INSERT BERHASIL -->

         <script>
 window.setTimeout(function() {
    $("#myAlert").fadeTo(500, 0).slideUp(1000, function(){
        $(this).remove();
    });
}, 5000);
</script>

<!-- if -->

<?php
  if($insert == "5"){
    // var_dump($insert);
    ?>
  <div id="myAlert" class="alert alert-warning alert-dismissible fade in" role="alert">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> Gagal!</strong> <?php echo $dataapa;?> Kuantiti penjualan melebihi sisa stok ke Data.
</div>

<?php
  }
  if($insert == "3"){
    ?>
  <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> Berhasil!</strong> <?php echo $dataapa;?> telah <b>terupdate</b>.
</div>

<!-- BOX UPDATE GAGAL -->
<?php
  }
  ?>

       <!-- BOX INFORMASI -->
    <?php
if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin') {
  ?>


  <!-- KONTEN BODY AWAL -->
                            <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Data <?php echo $dataapa;?> | Eceran</h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                <!-- <h5>Untuk penjualan ke eceran, tekan tombol</h5> -->

                <div class="table-responsive">

    <!----------------KONTEN------------------->
      <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

    $kode=$nama=$hargajual=$hargabeli=$jumlah=$hargaakhir=$tglnota=$bayar=$kembalian="";
    $no = $_GET["no"];
    $kode = $_POST['kode'];
    $hargaakhir = $_POST['hargaakhir'];
    $tglnota = $_POST['tglnota'];
    $datatotal = $_POST['datatotal'];
    $insert = '1';





    if(($no != null || $no != "") && ($chmod >= 3 || $_SESSION['jabatan'] == 'admin')){

         $sql="select * from $tabeldatabase where kode='$kode'";
          $hasil2 = mysqli_query($conn,$sql);
          


                  while ($fill = mysqli_fetch_assoc($hasil2)){


          $kode = $fill["kode"];
          $nama = $fill["nama"];
                  $insert = '3';

    }
    }
    ?>
    <?php

    if($kode == null || $kode == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];

            $sqle="SELECT SUM(hargabeliakhir) as data FROM transaksimasuk WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $databelitotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota='$kode'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];

      $sqle="SELECT SUM(hargabeliakhir) as data FROM transaksimasuk WHERE nota='$kode'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $databelitotal=$row['data'];


    }


    if(isset($_POST["tambah"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
              $barang = mysqli_real_escape_string($conn, $_POST["barang"]);
              $hargajual = mysqli_real_escape_string($conn, $_POST["hargajual"]);
              $hargabeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
              $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
              $hargaakhir = mysqli_real_escape_string($conn, $_POST["hargaakhir"]);
              $isipersatuan = mysqli_real_escape_string($conn, $_POST["isipersatuan"]);

              $hargabeliakhir = mysqli_real_escape_string($conn, round(($_POST["hargabeli"] / $_POST['isipersatuan'] )*$_POST["jumlah"]));
              $stok = mysqli_real_escape_string($conn, $_POST["stok"]);
              $insert = ($_POST["insert"]);

              $hargabelisatuan = mysqli_real_escape_string($conn, round(($_POST["hargabeli"] / $_POST['isipersatuan'])));

              if ($hargajual < $hargabelisatuan) {
                echo '<script type="text/javascript" src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>';
                echo '<script type="text/javascript">alertify.alert("Peringatan", "Harga Jual lebih kecil dari Harga Beli !", function (e) {
                  if (e) {
                    window.location.assign("add_jual_eceran");
                  }
                });
                </script>';
              
                return true;
                // exit;
              }

                 $sql="select * from $tabeldatabase where nota='$kode' and kode='$barang'";
                 $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

                  } else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')&&($jumlah <= $stok && $jumlah >= '1')){
            

            $sqle3="SELECT * FROM barang where barcode='$barang'";

            $hasile3=mysqli_query($conn,$sqle3);
            $row=mysqli_fetch_assoc($hasile3);
            $terjualawal=$row['terjual'];
            $terjualawaleceran=$row['terjualeceran'];
            $terbelieceran=$row['terbelieceran'];
            $sisa=$row['sisa'];
            $stokeceranawal=$row['stokeceran'];

            $stokeceran = $stokeceranawal - $jumlah;
            

            $ceksatuan = $sisa * $isipersatuan;
            $ceksatuan1 = $sisa * $isipersatuan - $isipersatuan;
           
            
            $stokeceranterjual = $terbelieceran - $stokeceran;
          // var_dump()
            
            if ($ceksatuan > $stokeceran ) {
              if ($ceksatuan1 < $stokeceran) {
                  $kuranginsisa = $sisa - 1;
                  $tambahinterjual = $terjualawal + 1;

                  if ($stokeceran >= '0') {
                      $sql2 = "insert into $tabeldatabase (nota, kode, nama, harga, hargabeli, jumlah, hargaakhir, hargabeliakhir, flagging, last_update) values( '$kode','$barang','$nama','$hargajual',$hargabeli,'$jumlah','$hargaakhir','$hargabeliakhir', '1', NOW())";
                      $insertan = mysqli_query($conn, $sql2);
     
                      $sql3 = "UPDATE barang SET terjual='$tambahinterjual', sisa='$kuranginsisa', stokeceran='$stokeceran', terjualeceran='$stokeceranterjual' where barcode='$barang'";
                      $updatestok = mysqli_query($conn, $sql3);
                  } else {
                    
                  }
              }                 

                }else {

                    $sql2 = "insert into $tabeldatabase (nota, kode, nama, harga, hargabeli, jumlah, hargaakhir, hargabeliakhir, flagging, last_update) values( '$kode','$barang','$nama','$hargajual',$hargabeli,'$jumlah','$hargaakhir','$hargabeliakhir', '1', NOW())";
                    $insertan = mysqli_query($conn, $sql2);
     
                    $sql3 = "UPDATE barang SET terjualeceran='$stokeceranterjual', stokeceran='$stokeceran' where barcode='$barang'";
                    $updatestok = mysqli_query($conn, $sql3);

            }

          }else{

            echo "<script>alert('Data qty jual melebihi sisa stok')</script>";
             }

      }

    }




    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
              $bayar = mysqli_real_escape_string($conn, $_POST["bayar"]);
              $kembalian = mysqli_real_escape_string($conn, $_POST["kembalian"]);
              $kasir = $_SESSION["username"];
              $insert = ($_POST["insert"]);


                 $sql="select * from bayar where nota='$kode'";
            $result=mysqli_query($conn,$sql);


                  if(mysqli_num_rows($result)>0){

              }
          else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')&&($bayar >= $datatotal && $bayar != null)){
            // var_dump($datatotal);die;

               $sql2 = "insert into bayar (nota, tglbayar, bayar, total, kembali, keluar, kasir, last_update) values( '$kode','$tglnota','$bayar','$datatotal','$kembalian','$databelitotal','$kasir', NOW())";
               $insertan = mysqli_query($conn, $sql2);

?>
<script type="text/javascript">
window.onload = function () {
  var win = window.open('print_one.php?nota=<?php echo $kode;?>', 'Cetak', ' menubar=0, resizable=0,dependent=0,status=0,width=260,height=400,left=10,top=10', '_blank');
  if (win) {
    win.focus();
    window.location = 'add_jual';
  } else {

  }
  
}

</script>

<?php

      //         echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
//echo "<script type='text/javascript'>window.location = 'add_jual';</script>";
             }else{

             }

      }

    }



    if($kode == null || $kode == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM transaksimasuk WHERE nota='$kode'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];


    }


             ?>

<a href="add_jual.php" id="addjual" name="addjual" style="display:none;">Mana</a>
  <div id="main">
   <div class="container-fluid">
   <a class="btn btn-info pull-right" href="add_jual.php" >Form Data Penjualan Non Eceran : <b>  CTRL + M</b></a>
   <br>
    <form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>" id="Myform" class="form-user">
              <div class="box-body">

              <div class="box-header with-border">

                <div class="row">
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                      <input type="text" name="barang" id="barang" class="form-control input-lg" size="10"
                        maxlength="13" value="" autocomplete="off" 
                        onkeydown="return event.key != 'Enter';" onkeyup="jump001(this, 'hargajual')"
                        placeholder="Scan Barcode">
                      <div id="suggesstion-box" style="z-index:100; position: absolute;margin-top:35px"></div>
                    </div>
                    <span class="label label-warning">ALT + 1</span>
                  </div>

                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                      <input type="text" class="form-control input-lg" id="nama" name="nama" value="" placeholder="Nama Barang"
                          readonly>
                    </div>
                  </div>

                </div>
                <br>

                <div class="row">

                  <div class="col-md-2">
                      <label for="stok">Sisa Stok</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-warning"></i></span>
                      <input type="text" class="form-control" id="stok" name="stok" value="" readonly placeholder="Sisa Stok">
                      <input type="hidden" id="isipersatuan" name="isipersatuan">
                    </div>
                  </div>
                  <input type="text" id="hargabeli" name="hargabeli" value="" style="display:none;">
                  <div class="col-md-3">
                  <label for="stok">Harga Satuan</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-money"></i></span>
                      <input type="number" class="form-control" id="hargajual" name="hargajual" autocomplete="off" placeholder="Harga Satuan" value="" onkeydown="return event.key != 'Enter';">
                    </div>
                      <span class="label label-warning">ALT + 2</span>
                  </div>

                  <div class="col-md-3">
                  <label for="stok">Jumlah Kuantitas</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
                      <input type="number" class="form-control" id="jumlah" name="jumlah" autocomplete="off" value="" placeholder="Jumlah Kuantitas"
                        onkeyup="sum();">
                      <!-- <span class="input-group-addon" id="satuan" value=""></span> -->
                    </div>
                    <span class="label label-warning">ALT + 3</span>
                    <br>
                    <br>
                  </div>

                  <div class="col-md-4">
                  <label for="stok">Harga Total</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-tasks"></i></span>
                      <input type="text" class="form-control" id="hargaakhir" name="hargaakhir" placeholder="Total" value="" readonly>
                    </div>
                    <br>
                    <br>
                  </div>
                  

                </div>

                <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                      <div class="box-body">
                
                      <div class="box-header with-border">
                        <h3 style="text-align:center;margin-top:5px;">Daftar Transaksi</h3>
                      </div>

                      <br>

                      <div class="row">
                  <div class="col-md-6">
                    <label for="kode" class="col-md-3 control-label" style="text-align:left;">No. Nota:</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="kode" name="kode" value="<?php echo autoNumber(); ?>"
                        maxlength="50" readonly>
                    </div>
                  </div> <!-- colom nota- -->

                  <div class="col-md-6">
                    <label for="tglnota" class="col-sm-5 control-label" style="text-align:right;">Tanggal Nota:</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control pull-right" id="datepicker2" name="tglnota"
                        placeholder="Masukan Tanggal Nota" value="<?php echo $tglnota; ?>">
                  <span class="label label-warning">ALT + 4</span>
                    </div>
                  </div> <!-- colom tanggal nota- -->
                </div> <!-- row nota dan tanggal -->


                <?php error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); ?>

                <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >

            </div>

                  <div class="row" >


                                                <script>
                                               function sum() {
                                                     var txtFirstNumberValue =  document.getElementById('jumlah').value
                                                     var txtSecondNumberValue = document.getElementById('hargajual').value;
                                                     var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
                                                     if (!isNaN(result)) {
                                                        document.getElementById('hargaakhir').value = result;
                                                     }
                                                   if (!$(jumlah).val()){
                                                     document.getElementById('hargaakhir').value = "0";
                                                   }
                                                   if (!$(hargajual).val()){
                                                     document.getElementById('hargaakhir').value = "0";
                                                   }
                                               }
                                               </script>



                  </div>
                </br>




    <br>



              <div class="row">
              <div class="col-md-12">


           <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "SELECT transaksimasuk.*,
           barang.satuan, satuan.nama as nama_satuan  FROM transaksimasuk
            LEFT JOIN barang ON transaksimasuk.kode = barang.barcode
            LEFT JOIN satuan ON barang.satuan = satuan.kode
           WHERE nota =".autoNumber()." order by transaksimasuk.no
           ";
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
           <div class="box-body table-responsive">
              <table class="data table table-hover table-bordered">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Harga Satuan</th>
                          <th>Satuan</th>
                          <th>Jumlah Jual</th>
                          <th>Total Pembayaran</th>
           <?php  if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                          <th>Opsi</th>
           <?php }else{} ?>
                      </tr>
                  </thead>
                    <?php
           error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
           while(($count<$rpp) && ($i<$tcount)) {
           mysqli_data_seek($result,$i);
           $fill = mysqli_fetch_array($result);
           ?>
           <tbody>
           <tr>
           <td><?php echo ++$no_urut;?></td>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['kode']); ?></td>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
           <td>Rp. <?php  echo mysqli_real_escape_string($conn, number_format($fill['harga'], $decimal, $a_decimal, $thousand).',-'); ?></td>
           
           <?php if ( mysqli_real_escape_string ($conn, $fill['flagging']) == '0' ) : ?>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
           <?php else : ?>
           <td> Eceran </td>
           <?php endif; ?>
           
           <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
           <td>Rp. <?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td>

           <?php if ( mysqli_real_escape_string ($conn, $fill['flagging']) == '1' ) : ?>
           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_produk_eceran?get=<?php echo '1'.'&'; ?>barang=<?php echo $fill['kode'].'&'; ?>jumlah=<?php echo $fill['jumlah'].'&'; ?>kode=<?php echo $kode.'&'; ?>no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo "add_".$forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
           <?php } else {}?>

           <?php else : ?>

           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_produk?get=<?php echo '1'.'&'; ?>barang=<?php echo $fill['kode'].'&'; ?>jumlah=<?php echo $fill['jumlah'].'&'; ?>kode=<?php echo $kode.'&'; ?>no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo "add_".$forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
           <?php } else {}?>
            
           <?php endif; ?>
           </td></tr>
           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>

           <br>
           <button  style="display:none;" type="submit" class="btn btn-block pull-left btn-flat btn-success" name="tambah" onclick="SubmitForm()" ><span class="glyphicon glyphicon-shopping-cart"></span> Tambah</button>
           <div class="row">
             <div class="form-group col-md-12">
               <div class="col-md-9">
                 <h3 align="right">Jumlah Harga</h3>
               </div>
               <div class="col-md-3">
                         
                  <?php if($datatotal == "" || $datatotal == null){?>
                    <h1 align="right">Rp   <?php echo '0'.',-'; ?></h1>
                    <?php }else{ ?>
                    <h1 align="right">Rp   <?php echo number_format($datatotal, $decimal, $a_decimal, $thousand).',-'; ?></h1>
                  <?php } ?>
                  
                      </div>
                    </div>



                            <div class="row">
                              <div class="col-md-12">
                                <div class="box box-solid">
                                  <div class="box-header with-border">

                                    <script>
                                   function sum2() {
                                         var txtFirstNumberValue =  document.getElementById('bayar').value
                                         var txtSecondNumberValue = document.getElementById('total').value;
                                         var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
                                         if (!isNaN(result)) {
                                            document.getElementById('kembalian').value = result;
                                         }
                                       if (!$(bayar).val()){
                                         document.getElementById('kembalian').value = "0";
                                       }
                                       if (!$(total).val()){
                                         document.getElementById('kembalian').value = "0";
                                       }
                                   }
                                   </script>

                                   </div>
                                   </div>

                                    <div class="row" >
                                       <div class="form-group col-md-6 col-xs-12" >
                                              <label for="bayar" class="col-sm-2 control-label">Bayar:</label>
                                              <div class="col-sm-10">
                                                <input type="number" autocomplete="off" class="form-control" id="bayar" name="bayar" value="<?php echo $bayar; ?>" maxlength="50" placeholder="Masukan Jumlah Dibayar" onkeyup="sum2();">
                                                <span class="label label-warning">ALT + 5</span>
                                              </div>
                                            </div>

                                            <input type="hidden" class="form-control" id="total" name="total" value="<?php echo $datatotal; ?>" maxlength="50" >

                                       <div class="form-group col-md-6 col-xs-12" >
                                              <label for="kembalian" class="col-sm-2 control-label">Kembalian:</label>
                                              <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kembalian" name="kembalian" value="<?php echo $kembalian; ?>" maxlength="50" readonly>
                                              </div>
                                            </div>
                                    </div>




                              </div>
                            </div>

<br>
              <!-- /.box-body -->
              <div class="box-footer" >
                <div class="col-md-12">
                <button type="submit" class="btn btn-block pull-left btn-flat btn-danger btn-lg" id="simpan" name="simpan" onclick="document.getElementById('Myform').submit();" ><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
                <span class="label label-warning">ALT + 0</span>
            </div>
            
              </div>
              <!-- /.box-footer -->


 </form>






</div>


<script>
function myFunction() {
    document.getElementById("Myform").submit();
}
</script>

    <!-- KONTEN BODY AKHIR -->

                                </div>
                </div>

                                <!-- /.box-body -->
                            </div>
                        </div>

<?php
} else {
?>
   <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa;?> ini .</b>
    </div>
    <?php
}
?>
                        <!-- ./col -->
                    </div>

                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <!-- /.Left col -->
                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php  footer(); ?>
            <div class="control-sidebar-bg"></div>
        </div>
          <!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script>
shortcuts.add('alt+1',function() {
  let fieldBarang = document.getElementById('barang').focus();
})
shortcuts.add('alt+2',function() {
  let fieldBarang = document.getElementById('hargajual').focus();
})
shortcuts.add('alt+3',function() {
  let fieldBarang = document.getElementById('jumlah').focus();
})
shortcuts.add('alt+4',function() {
  let fieldBarang = document.getElementById('datepicker2').focus();
})
shortcuts.add('alt+5',function() {
  // $("#supplier").select2();
  fieldSupplier = document.getElementById('bayar').focus();
})
shortcuts.add('alt+0',function() {
  let fieldBarang = document.getElementById('simpan').click();
})
shortcuts.add('ctrl+m',function() {
  document.getElementById('addjual').click();
})
</script>
<script>
$(document).ready(function() {

$('#barang').on('keyup', function() {

    if (event.keyCode === 13 || $(this).val().length >= 10) {
      $.ajax({
          type: 'POST',
          url: 'component/ajax/addjualeceran_search.php',
          data: {
              barang: $(this).val()
          },
          dataType : 'json',
          success: function(data) {
            // console.log(data[0].hargabeli);
            $("#nama").val(data[0].nama);
            $("#stok").val(data[0].stokeceran);
            $("#isipersatuan").val(data[0].isipersatuan);
            $("#hargabeli").val(data[0].hargabeli);
            $("#hargaakhir").val("");
            $("#jumlah").val("");
            document.getElementById('satuan').innerHTML = data[0].nama_satuan;
          }
      });
    }
  });

  $('#barang').on('keyup', function() {
        $.ajax({
            type: 'POST',
            url: 'component/ajax/addjualeceranmanual_search.php',
            data: 'barang=' + $(this).val(),
            beforeSend: function () {
              $("#barang").css("background", "#FFF dist/img/(LoaderIcon.gif) no-repeat 165px");
            },
            success: function (data) {
              // console.log(data);
              $("#suggesstion-box").show();
              $("#suggesstion-box").html(data);
              $("#barang").css("background", "#FFF");
            }
        });
      });

});



function pilihBarang(val) {
  $.ajax({
    type: "POST",
    url: "component/ajax/addjualeceranmanual_selected.php",
    data: {
      barcode: val
    },
    dataType: 'json',
    success: function (data) 
    {
      console.log(data);

      $("#nama").val(data[0].nama);
      $("#stok").val(data[0].stokeceran);
      $("#isipersatuan").val(data[0].isipersatuan);
      $("#hargabeli").val(data[0].hargabeli);
      $("#hargaakhir").val("");
      $("#jumlah").val("");

      // $("#nama").val(data[0].nama);
      // $("#hargajual").val(data[0].hargajual);
      // $("#stok").val(data[0].sisa);
      // $("#isipersatuan").val(data[0].isipersatuan);
      // $("#hargabeli").val(data[0].hargabeli);
      // $("#hargaakhir").val("");
      // $("#jumlah").val("");
    }
  })
  $("#barang").val(val);
  $("#suggesstion-box").hide();
}
</script>


        <script src="dist/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="dist/plugins/morris/morris.min.js"></script>
        <script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="dist/plugins/knob/jquery.knob.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="dist/plugins/fastclick/fastclick.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>
    <script src="dist/plugins/select2/select2.full.min.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="dist/plugins/iCheck/icheck.min.js"></script>
    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy/mm/dd"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY/MM/DD h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
            'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

   $('.datepicker').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });

   //Date picker 2
   $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

   $('.datepicker2').datepicker({
    dateFormat: 'yyyy-mm-dd'
 });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    // $(".my-colorpicker1").colorpicker();
    //color picker with addon
    // $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
</body>
</html>
