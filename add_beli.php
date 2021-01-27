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
$halaman = "beli"; // halaman
$dataapa = "Pembelian"; // data
$tabeldatabase = "transaksibeli"; // tabel database
$chmod = $chmenu5; // Hak akses Menu
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
$insert = $_POST['insert'];

 function autoNumber(){
  include "configuration/config_connect.php";
  global $forward;
  $query = "SELECT (RIGHT(nota, 5)) as max_id FROM beli ORDER BY no DESC LIMIT 0, 1";
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


<!-- SETTING STOP -->
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
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
    var satuan = $("#satuan").text();
    var nama = $("#nama").val();
    var hargabeli = $("#hargabeli").val();
    var jumlah = $("#jumlah").val();
    var hargaakhir = $("#hargaakhir").val();
    var isipersatuan = $("#isipersatuan").val();
    var datatotal = $("#datatotal").val();


    if (nama == "") {
      event.preventDefault();
    } else {
      if (hargabeli == "0") {
        alertify.alert('Peringatan', 'Harga beli tidak boleh kosong!', function () {});
        event.preventDefault();
      } else if (jumlah == "") {
        alertify.alert('Peringatan', 'Jumlah beli tidak boleh kosong!', function () {});
        event.preventDefault();
      }
    }

    
    // event.preventDefault();

    $.post("add_beli.php", {
      kode: kode,
      barang: barang,
      nama: nama,
      hargabeli: hargabeli,
      jumlah: jumlah,
      satuan: satuan,
      hargaakhir: hargaakhir,
      isipersatuan : isipersatuan,
      datatotal: datatotal
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
<?php
  if($insert == "10"){
    ?>
  <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> Berhasil!</strong> <?php echo $dataapa;?> telah berhasil <b>ditambahkan</b> ke Data <?php echo $dataapa;?>.
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
              <h3 class="box-title">Data <?php echo $dataapa;?></h3>
            </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
      <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

    $kode=$nama=$hargabeli=$jumlah=$hargaakhir=$tglnota=$bayar=$kembalian="";
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

            $sqle="SELECT SUM(hargaakhir) as data FROM transaksibeli WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM transaksibeli WHERE nota='$kode'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];


    }


    if(isset($_POST["tambah"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
              $barang = mysqli_real_escape_string($conn, $_POST["barang"]);
              $hargabeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
              $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
              $isipersatuan = mysqli_real_escape_string($conn, $_POST["isipersatuan"]);
              $hargaakhir = mysqli_real_escape_string($conn, $_POST["hargaakhir"]);
              $stok = mysqli_real_escape_string($conn, $_POST["stok"]);
              $insert = ($_POST["insert"]);

              $sql="select * from $tabeldatabase where nota='$kode' and kode='$barang'";
              $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

              }
          else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')&&($jumlah >= '1')){
// transaksibeli
 
               $sql2 = "insert into $tabeldatabase (nota, kode, nama, harga, jumlah, hargaakhir, last_update) values( '$kode','$barang','$nama','$hargabeli','$jumlah','$hargaakhir', NOW())";
               $insertan = mysqli_query($conn, $sql2);

              $sqle3="SELECT * FROM barang where barcode='$barang'";
              $hasile3=mysqli_query($conn,$sqle3);
              $row=mysqli_fetch_assoc($hasile3);
              $sisaawal=$row['sisa'];
              $terbeliawal=$row['terbeli'];
              $terjualawal=$row['terjual'];
              $terbeliawaleceran=$row['terbelieceran'];
              $stokeceranawal=$row['stokeceran'];
               
              $terbeliakhir = $terbeliawal + $jumlah;

              $sisaakhir = $terbeliakhir - $terjualawal;
              
              // $stokeceran = $sisaakhir * $isipersatuan;              
              $sisa1 = $stok * $isipersatuan;
              $sisa2 = $stokeceranawal - $sisa1;
              $sisa3 = $sisaakhir * $isipersatuan;
              $stokeceran = $sisa3 + $sisa2;

              $terbelieceran = $terbeliakhir * $isipersatuan;
               

              if ($isipersatuan != "") {
                $sql3 = "UPDATE barang SET hargabeli='$hargabeli', terbeli='$terbeliakhir', sisa='$sisaakhir', isipersatuan='$isipersatuan', stokeceran='$stokeceran', terbelieceran='$terbelieceran' where barcode='$barang'";
                $updatestok = mysqli_query($conn, $sql3);
              } else {
                $sql3 = "UPDATE barang SET hargabeli='$hargabeli', terbeli='$terbeliakhir', sisa='$sisaakhir', terbelieceran='$terbelieceran' where barcode='$barang'";
                $updatestok = mysqli_query($conn, $sql3);
              }

              //  var_dump($updatestok);die;


             }else{

             }

      }

      // header('Location: https://stackoverflow.com');
      // end();

    }




    if(isset($_POST["simpan"])){
       if($_SERVER["REQUEST_METHOD"] == "POST"){

              $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
              $tglnota = mysqli_real_escape_string($conn, $_POST["tglnota"]);
              $supplier = mysqli_real_escape_string($conn, $_POST["supplier"]);
              $keterangan = mysqli_real_escape_string($conn, $_POST["keterangan"]);
              $kasir = $_SESSION["username"];
              $insert = ($_POST["insert"]);
              // var_dump($supplier);

              if ($supplier == "") {
                echo '<script type="text/javascript">window.location = "add_beli";</script>';
                return true;
              }


                $sql="select * from beli where nota='$kode'";
            $result=mysqli_query($conn,$sql);

                  if(mysqli_num_rows($result)>0){

              }
          else if(( $chmod >= 2 || $_SESSION['jabatan'] == 'admin')){

               $sql2 = "insert into beli (nota, tglbeli, total, supplier, kasir, keterangan, last_update) values( '$kode','$tglnota','$datatotal','$supplier','$kasir','$keterangan', NOW())";
               $insertan = mysqli_query($conn, $sql2);

               echo "<script type='text/javascript'>window.location = 'add_beli';</script>";
             }else{

             }

      }

    }



    if($kode == null || $kode == ""){

            $sqle="SELECT SUM(hargaakhir) as data FROM transaksibeli WHERE nota=".autoNumber()."";
            $hasile=mysqli_query($conn,$sqle);
            $row=mysqli_fetch_assoc($hasile);
            $datatotal=$row['data'];
    }else{

      $sqle="SELECT SUM(hargaakhir) as data FROM transaksibeli WHERE nota='$kode'";
      $hasile=mysqli_query($conn,$sqle);
      $row=mysqli_fetch_assoc($hasile);
      $datatotal=$row['data'];


    }


             ?>



  <div id="main">
   <div class="container-fluid">
      <form class="form-horizontal" method="post" action="add_<?php echo $halaman; ?>"  id="Myform" class="form-user" >
              <div class="box-body">

              <div class="box-header with-border">

              <div class="row">
                <div class="col-md-7">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                    <input type="text" name="barang" id="barang" autocomplete="off" class="form-control input-lg"
                      size="10" maxlength="13" onkeyup="jump001(this, 'jumlah')" value="" placeholder="Scan Barcode">
                    <div id="suggesstion-box" style="z-index:100; position: absolute;margin-top:35px"></div>
                  </div>
                  <span class="label label-warning">ALT + 1</span>
                </div>

                <div class="col-md-5">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
                    <input type="text" class="form-control input-lg" id="nama" placeholder="Nama Barang" name="nama" value=""
                      placeholder="" readonly>
                  </div>
                </div>
              </div>

              <br>

              <div class="row">
                <div class="col-md-3">
                <label for="barang">Harga Beli Satuan</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    <input type="number" onkeydown="return event.key != 'Enter';" class="form-control" placeholder="Harga Beli Satuan" autocomplete="off" id="hargabeli"
                      name="hargabeli" value="">
                  </div>
                  <span class="label label-warning">ALT + 2</span>
                </div>
              
              <div class="col-md-3">
              <label for="barang">Jumlah Satuan</label>
                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
                  <input type="number" step=".01" class="form-control" size="13" autocomplete="off" maxlength="15" id="jumlah" name="jumlah" value="" placeholder="Jumlah Satuan" onkeyup="sum();">
                  <span class="input-group-addon" id="satuan" value=""></span>
                </div>
                <span class="label label-warning">ALT + 3</span>
                <br>
              </div>
              
              <div class="col-md-3">
              <label for="barang">Isi per Kemasan</label>
                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
                  <input type="number" onkeydown="return event.key != 'Enter';" class="form-control" size="13" autocomplete="off" maxlength="15" id="isipersatuan" name="isipersatuan" value="1" placeholder="Isi per Kemasan" onkeyup="sum();" readonly>

                </div>
                <span class="label label-warning">ALT + 4</span>
                <br>
              </div>
              
              <div class="col-md-3">
              <label for="barang">Total</label>
                <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tasks"></i></span>
                  <input type="text" class="form-control" id="hargaakhir" name="hargaakhir" value="" placeholder="Total" readonly>
                </div>
                <br>
              </div>
              
              </div>
              </div>
              </div>
              </div>
              </div>


              <br>

                <div class="row">

                  <div class="col-md-12">
                    <div class="box box-info">
                      <div class="box-body">

                      <div class="box-header with-border">
                        <h3 style="text-align:center;margin-top:5px;">Daftar Barang</h3>
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
                    <span class="label label-warning">ALT + 5</span>
                    </div>
                  </div> <!-- colom tanggal nota- -->
                </div> <!-- row nota dan tanggal -->



           <?php error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); ?>





      <input type="hidden" class="form-control" id="insert" name="insert" value="<?php echo $insert;?>" maxlength="1" >


              </div>

                  <div class="row" >

                    <div class="col-sm-3" style="display:none;">
                    <label for="usr" >Sisa Stok</label>
                    <input type="text" class="form-control" id="stok" name="stok" value="" readonly>
                  </div>

                                                <script>
                                               function sum() {
                                                     var txtFirstNumberValue =  document.getElementById('jumlah').value
                                                     var txtSecondNumberValue = document.getElementById('hargabeli').value;
                                                     var result = parseFloat(txtFirstNumberValue) * parseFloat(txtSecondNumberValue);
                                                     if (!isNaN(result)) {
                                                        document.getElementById('hargaakhir').value = result;
                                                     }
                                                   if (!$(jumlah).val()){
                                                     document.getElementById('hargaakhir').value = "";
                                                   }
                                                   if (!$(hargabeli).val()){
                                                     document.getElementById('hargaakhir').value = "";
                                                   }
                                               }
                                               </script>


                  </div>

                  <input type="hidden" class="form-control" id="total" name="total" value="<?php echo $datatotal; ?>" maxlength="50" >
                       

                </br>






              <div class="row">
                <div class="col-md-12">

           <?php
           error_reporting(E_ALL ^ E_DEPRECATED);

           $sql    = "SELECT
           transaksibeli.*,
           barang.hargabeli as harga_katalog,
           barang.isipersatuan,
           satuan.nama as nama_satuan
           FROM
           transaksibeli
           LEFT JOIN barang ON transaksibeli.kode = barang.barcode
           LEFT JOIN satuan ON barang.satuan = satuan.kode
           WHERE
           transaksibeli.nota =".autoNumber()." 
           ORDER BY
           transaksibeli.NO";
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
                          <th>Harga Beli</th>
                          <th>Satuan</th>
                          <th>Isi per Kemasan</th>
                          <th>Jumlah Beli</th>
                          <th>Total Bayar</th>
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
           <td><?php  echo mysqli_real_escape_string($conn, $fill['nama_satuan']); ?></td>
           <?php if (mysqli_real_escape_string($conn, $fill['isipersatuan']) == null) : ?>
           <td align="center"> - </td>
           <?php else : ?>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['isipersatuan']); ?></td>
           <?php endif; ?>
           <td><?php  echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
           <td>Rp. <?php  echo mysqli_real_escape_string($conn, number_format(($fill['jumlah']*$fill['harga']), $decimal, $a_decimal, $thousand).',-'); ?></td>
           <td>
           <?php  if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
           <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_produk_beli?get=<?php echo '2'.'&'; ?>barang=<?php echo $fill['kode'].'&'; ?>jumlah=<?php echo $fill['jumlah'].'&'; ?>kode=<?php echo $kode.'&'; ?>no=<?php echo $fill['no'].'&'; ?>forward=<?php echo $forward.'&';?>forwardpage=<?php echo "add_".$forwardpage.'&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
           <?php } else {}?>
           </td></tr>
           <?php
           $i++;
           $count++;
           }

           ?>
           </tbody></table>
           <div align="right"><?php if($tcount>=$rpp){ echo paginate_one($reload, $page, $tpages);}else{} ?></div>

<br>
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
                      </div>

           <input type="hidden" class="form-control" id="total" name="total" value="<?php echo $datatotal; ?>" maxlength="50" >

           </div>
           </div>
           <button style="display:none;" type="submit" class="btn btn-block pull-left btn-flat btn-info" name="tambah" onclick="SubmitForm()" >
                  <span class="glyphicon glyphicon-shopping-cart"></span>Tambah
                  </button>

         </div>
                  </div>
                </div>



                            <div class="row">
                              <div class="col-md-12">
                                <div class="box box-solid">
                                  <div class="box-header with-border">


                                    <div class="row" >
                                       <div class="form-group col-md-6 col-xs-12" >
                                              <label for="supplier" class="col-sm-2 control-label">Supplier:</label>
                                              <div class="col-sm-10">
                                                <select class="form-control select2" style="width: 100%;" name="supplier" id="supplier">
                                                  <option></option>
                                          <?php
                                    $sql=mysqli_query($conn,"select * from supplier");
                                    while ($row=mysqli_fetch_assoc($sql)){
                                      if ($supplier==$row['kode'])
                                      echo "<option value='".$row['kode']."' selected='selected'>".$row['kode']." | ".$row['nama']."</option>";
                                      else
                                      echo "<option value='".$row['kode']."'>".$row['kode']." | ".$row['nama']."</option>";
                                    }
                                  ?>
                                                </select>
                                                <span class="label label-warning">ALT + 6</span>
                                              </div>
                                            </div>


                                       <div class="form-group col-md-6 col-xs-12" >
                                              <label for="keterangan" class="col-sm-2 control-label">Keterangan:</label>
                                              <div class="col-sm-10">
                                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $keterangan; ?>" maxlength="200">
                                            <span class="label label-warning">ALT + 7</span>
                                              </div>
                                            </div>
                                    </div>

                                  </div>
                                </div>
                              </div>
                            </div>

              <!-- /.box-body -->
              <div class="box-footer" >
                <div class="col-md-12">
                    <!-- <button type="submit" name="add_user" class="btn btn-primary" id="validateButton2">Submit</button> -->
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
                    </div>
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
  fieldBarang = document.getElementById('barang').focus();
})
shortcuts.add('alt+2',function() {
  fieldBarang = document.getElementById('hargabeli').focus();
})
shortcuts.add('alt+3',function() {
  fieldBarang = document.getElementById('jumlah').focus();
})
shortcuts.add('alt+4',function() {
  let fieldBarang = document.getElementById('isipersatuan').focus();
})
shortcuts.add('alt+5',function() {
  let fieldBarang = document.getElementById('datepicker2').focus();
})
shortcuts.add('alt+6',function() {
  $('#supplier').select2('open');
})
shortcuts.add('alt+7',function() {
  let fieldBarang = document.getElementById('keterangan').focus();
})
shortcuts.add('alt+0',function() {
  let fieldBarang = document.getElementById('simpan').click();
  console.log(fieldBarang);
})
</script>




<script>
$(document).ready(function() {

  $('#barang').on('keyup', function() {
      if (event.keyCode === 13 || $(this).val().length >= 10) {
        $.ajax({
            type: 'POST',
            url: 'component/ajax/addbeli_search.php',
            data: {
                barang: $(this).val()
            },
            dataType : 'json',
            success: function(data) {
              console.log(data);
              $("#nama").val(data[0].nama);
              $("#hargabeli").val(data[0].hargabeli);
              $("#hargakatalog").val(data[0].hargabeli);
              $("#stok").val(data[0].sisa);
              $("#hargaakhir").val("");
              $("#jumlah").val("");
              // $("#isipersatuan").val(data[0].isipersatuan);
              
              if (data[0].isipersatuan != null) {
                $("#isipersatuan").val(data[0].isipersatuan);
              } else {
                 var isipersatuan = document.getElementById('isipersatuan');
                 isipersatuan.removeAttribute("readonly");
              }
              document.getElementById('satuan').innerHTML = data[0].nama_satuan;


            }
        });
      }
    });
    

    $('#barang').on('keyup', function() {
        $.ajax({
            type: 'POST',
            url: 'component/ajax/addbelimanual_search.php',
            data: 'barang=' + $(this).val(),
            beforeSend: function () {
              $("#barang").css("background", "#FFF dist/img/(LoaderIcon.gif) no-repeat 165px");
            },
            success: function (data) {
              $("#suggesstion-box").show();
              $("#suggesstion-box").html(data);
              $("#barang").css("background", "#FFF");
            }
        });
      });
    // }
});

function pilihBarang(val) {
  console.log(val);
  $.ajax({
    type: "POST",
    url: "component/ajax/addbelimanual_selected.php",
    data: {
      barcode : val
    },
    dataType: 'json',
    success : function(data) {
      console.log(data);
        $("#nama").val(data[0].nama);
        $("#stok").val(data[0].sisa);
        $("#hargabeli").val(data[0].hargabeli);
        $("#hargaakhir").val("");
        $("#barang").val(data[0].barcode);
        $("#jumlah").val("");
        if (data[0].isipersatuan != null) {
          $("#isipersatuan").val(data[0].isipersatuan);
        } else {
          var isipersatuan = document.getElementById('isipersatuan');
          isipersatuan.removeAttribute("readonly");
        }
        document.getElementById('satuan').innerHTML = data[0].nama_satuan;
    }  
  })
  $("#barang").val(val);
  $("#suggesstion-box").hide();
}
</script>

        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
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


    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });

  });
</script>
</body>
</html>
