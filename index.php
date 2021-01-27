<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
include "configuration/config_connect.php";
;encryption();session();connect();head();body();timing();

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
                <!-- Content Header (Page header) -->
                <section class="content-header">

</section>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- ./col -->

<!-- SETTING START-->

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING) );

$halaman = "index"; // halaman
$dataapa = "Dashboard"; // data
$tabeldatabase = "index"; // tabel database
$forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
$forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
$search = $_POST['search'];
?>

<!-- SETTING STOP -->


<!-- BREADCRUMB -->
<div class="col-lg-12">
<ol class="breadcrumb ">
<li><a href="#">Dashboard</a></li>
</ol>
</div>

<!-- BREADCRUMB -->




                                <!-- /.box-body -->

                        <!-- ./col -->

                </div>

<?php if($_SESSION['jabatan'] !='admin' && $_SESSION['jabatan'] == "Kasir"){}else{ ?>

                    <div class="row">

                         <div class="col-lg-4 col-xs-6">
                           <!-- small box -->
                           <div class="small-box bg-aqua">
                               <div class="inner">
                                   <h3><?php echo $datax1; ?></h3>
                                   <p>Karyawan</p>
                               </div>
                               <div class="icon">
                                   <i class="ion ion-person"></i>
                               </div>
                                 <a href="admin" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                           </div>
                       </div>

                       <div class="col-lg-4 col-xs-6">
                         <!-- small box -->
                         <div class="small-box bg-green">
                             <div class="inner">
                                 <h3><?php echo $datax2; ?></h3>
                                 <p>Supplier</p>
                             </div>
                             <div class="icon">
                                 <i class="ion ion-person"></i>
                             </div>
                               <a href="supplier" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                         </div>
                     </div>

                     <div class="col-lg-4 col-xs-6">
                       <!-- small box -->
                       <!-- <div class="small-box bg-yellow">
                           <div class="inner">
                               <h3><?php echo $datax3; ?></h3>
                               <p>Kategori</p>
                           </div>
                           <div class="icon">
                               <i class="glyphicon glyphicon-blackboard"></i>
                           </div>
                             <a href="kategori" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                       </div> -->
                   </div>

                   <div class="col-lg-4 col-xs-6">
                     <!-- small box -->
                     <div class="small-box bg-red">
                         <div class="inner">
                             <h3><?php echo $datax4; ?></h3>
                             <p>Barang</p>
                         </div>
                         <div class="icon">
                             <i class="glyphicon glyphicon-folder-close"></i>
                         </div>
                           <a href="barang" class="small-box-footer">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
                     </div>
                 </div>

                     </div>

<!-- Awal Chart  -->


<?php

    $tgl1 = date('Y-m-d',strtotime("-6day"));
    $tgl2 = date('Y-m-d');

$labaharian1 = mysqli_query($conn, "SELECT tglbayar FROM bayar WHERE nota IN ( SELECT nota FROM transaksimasuk )
AND tglbayar BETWEEN '".$tgl1."' AND '".$tgl2."' GROUP BY tglbayar");

$labaharian2 = mysqli_query($conn, "SELECT ( SUM( total ) - SUM( keluar ) ) AS total FROM bayar WHERE nota IN ( SELECT nota FROM transaksimasuk )
AND tglbayar BETWEEN '".$tgl1."' AND '".$tgl2."' GROUP BY tglbayar");

// while ($b = mysqli_fetch_array($labaharian)) { 
//     var_dump($b['tglbayar'], $b['total']);
// }




?>




<div class="row">

     <div class="col-lg-6 col-xs-12 col-sm 12 ">
      <div class="box box-solid box-success">
     

    
        <div class="chart-container responsive">
        <div class="row">
            <div class="col-md-6">
            <h4>
            <b style="margin-left:20px;">7 Hari Laba terakhir</b>
            </h4>
            </div>
        </div>
            <canvas  class="my-4 chartjs-render-monitor" id="myChart" height="400vw" width="520vw"></canvas>
        </div>
        <script src="dist/plugins/node_modules/echarts/dist/echarts.js"></script>

        <script>
        
            var myChart = echarts.init(document.getElementById('myChart'));

            var option = {
            tooltip: {
            trigger: 'axis',
                axisPointer: {
                    type: 'shadow',
                    label: {
                        show: true
                    }
                }
            },
            toolbox: {
                show: true,
                feature: {
                    mark: {show: true},
                    dataView: {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar']},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            calculable: true,
            dataZoom: [
                {
                    show: true,
                    start: 0,
                    end: 100
                },
                {
                    type: 'inside',
                    start: 94,
                    end: 100
                },
                {
                    show: true,
                    yAxisIndex: 0,
                    filterMode: 'empty',
                    width: 30,
                    height: '80%',
                    showDataShadow: false,
                    left: '93%'
                }
            ],
            legend: {
                data:['Stok']
            },
            xAxis: {
                type: 'category',
                data: [<?php while ($x = mysqli_fetch_array($labaharian1)) { echo '"' . $x['tglbayar'] . '" ,';} ; ?>],
                axisLabel: { interval: 0, rotate: 25 },
            },
            yAxis: {},
            series: [{
                name: 'Stok',
                type: 'bar',
                data: [<?php while ($y = mysqli_fetch_array($labaharian2)) { echo '"' . $y['total'] . '" ,';} ;?>]
            }]
        };
        myChart.setOption(option);
        $(window).on('resize', function(){
                if(chart != null && chart != undefined){
                    myChart.resize();
                }
            });
            
         </script>

         <script>

         </script>
    
    </div>
</div>

<div class="col-lg-6 col-xs-12 col-sm 12">
      <div class="box box-solid box-success">
<?php
$barang1      = mysqli_query($conn, "SELECT nama FROM barang WHERE terjual>'0' order by terjual desc LIMIT 0, 10");

$stok1 = mysqli_query($conn, "SELECT terjual FROM barang WHERE terjual>'0' order by terjual desc LIMIT 0, 10");
?>



        <style type="text/css">
            
        </style>
    
          
        <div class="chart-container">
        <div class="row">
            <div class="col-md-6">
            <h4>
            <b style="margin-left:20px;">10 Barang Terlaris</b>
            </h4>
            </div>
        </div>
            <canvas  class="my-4 chartjs-render-monitor" id="myChart1" height="400vw" width="520vw"></canvas>
          </div>
          <script src="dist/plugins/node_modules/echarts/dist/echarts.js"></script>
        <script>
            
            var myChart1 = echarts.init(document.getElementById('myChart1'));
            var option = {
            // title: {
            //     text: 'Penjualan Terlaris'
            // },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow',
                    label: {
                        show: true
                    }
                }
            },
            dataZoom: [
                {
                    show: true,
                    start: 0,
                    end: 100
                },
                {
                    type: 'inside',
                    start: 94,
                    end: 100
                },
                {
                    show: true,
                    yAxisIndex: 0,
                    filterMode: 'empty',
                    width: 30,
                    height: '80%',
                    showDataShadow: false,
                    left: '93%'
                }
            ],
            toolbox: {
                show: true,
                feature: {
                    mark: {show: true},
                    dataView: {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar']},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            calculable: true,
            legend: {
                data:['Stok']
            },
            xAxis: {
                type: 'category',
                data: [<?php while ($b = mysqli_fetch_array($barang1)) { echo '"' . $b['nama'] . '",';}?>],
                axisLabel: { interval: 0, rotate: 25 },
            },
            yAxis: {},
            series: [{
                name: 'Stok',
                type: 'bar',
                data: [<?php while ($p = mysqli_fetch_array($stok1)) { echo '"' . $p['terjual'] . '",';}?>]
            }]
        };
        // use configuration item and data specified to show chart
        myChart1.setOption(option);
            
         </script>
         <script>
           	var canvas = document.getElementById('myChart1');
            canvas.width = window.innerWidth * .8;
            canvas.height = window.innerHeight * .8;

              // start working with canvas - paint black to make visible
            ctx = canvas.getContext('2d');
            ctx.fillStyle = "#000";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
         </script>
    
    </div>
</div>
</div>

<!-- akhir chart -->
                <div class="row">
                <?php if($_SESSION['jabatan'] !='admin'){}else{ ?>

                                <div class="box-body">
                <div class="table-responsive">
    <!----------------KONTEN------------------->
      <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

      $nama=$avatar=$tanggal=$isi="";
      if($_SERVER["REQUEST_METHOD"] == "POST"){
                  $nama = $_SESSION['nama'];
                  $avatar = $_SESSION['avatar'];
                  $tanggal = date('Y-m-d');
                  $isi= $_POST["isi"];


    }

         $sql="select * from info";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){

          $nama = $fill["nama"];
                  $avatar = $fill["avatar"];
                  $tanggal = $fill["tanggal"];
                  $isi= $fill["isi"];


    }
    ?>
  <div id="main">

   <div class="container-fluid">
   <?php } ?>


</div>




    <!-- KONTEN BODY AKHIR -->

                                </div>
                </div>

                            </div>
              </div>

              <?php } ?>
              <?php if($_SESSION['jabatan'] !='admin'){?>
              <div class="col-md-12">
               <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

      $nama=$avatar=$tanggal=$isi="";
      if($_SERVER["REQUEST_METHOD"] == "POST"){
                  $nama = $_SESSION['nama'];
                  $avatar = $_SESSION['avatar'];
                  $tanggal = date('Y-m-d');
                  $isi= $_POST["isi"];


    }

         $sql="select * from info";
                  $hasil2 = mysqli_query($conn,$sql);


                  while ($fill = mysqli_fetch_assoc($hasil2)){

          $nama = $fill["nama"];
                  $avatar = $fill["avatar"];
                  $tanggal = $fill["tanggal"];
                  $isi= $fill["isi"];


    }
    ?>
              <?php
              }else{ ?>
                    <div class="col-md-6">

              <?php } ?>
          <!-- Box Comment -->




</div>
</div>


<!-- /.box-body -->
</div>

<!-- BATAS -->
</div>





                    <!-- /.row -->
                    <!-- Main row -->
                    <div class="row">

                    </div>
                    <!-- /.row (main row) -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
                   <?php footer();?>
            <div class="control-sidebar-bg"></div>
        </div>
              <script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
              <!-- <script src="dist/plugins/node_modules/echarts/dist/echarts.js"></script> -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

        
        <script>
  $.widget.bridge('uibutton', $.ui.button);
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
        <script src="dist/js/pages/dashboard.js"></script>
        <script src="dist/js/demo.js"></script>
    <script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="dist/plugins/fastclick/fastclick.js"></script>

    </body>
</html>
