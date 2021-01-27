<?php
include "configuration/config_connect.php";
include "configuration/config_chmod.php";
?>
 <aside class="main-sidebar">

                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php  echo $_SESSION['avatar']; ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php  echo $_SESSION['nama']; ?></p>
                            <a href="#"><i class="fa fa-circle text-online"></i> Online</a>
                            
                        </div>
                    </div>
<br>
                             <ul class="sidebar-menu">
                       <!-- <li class="header">MENU UTAMA</li> -->
                        <li class="treeview">
                            <a href="index"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>

                        </li>



<?php

if($chmenu2 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-th-list"></i> <span>Barang</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="barang"><i class="fa fa-circle-o"></i>Data Barang</a>
                                </li>
<li>
                                    <a href="add_barang"><i class="fa fa-circle-o"></i>Tambah Barang</a>
                                                  </li>

                            </ul>
                        </li>



<?php }else{}

if($chmenu5 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="add_beli"> <i class="glyphicon glyphicon-log-in"></i> <span>Menu Pembelian</span> <span class="pull-right-container"> </span> </a>
                                       </li>
    <?php }else{}

if($chmenu6 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="add_jual"> <i class="glyphicon glyphicon-shopping-cart"></i> <span>Menu Penjualan</span> <span class="pull-right-container"> </span> </a>

                        </li>

    <?php }else{}

if($chmenu7 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class=" glyphicon glyphicon-flash"></i> <span>Transaksi Operasional</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="operasional"><i class="fa fa-circle-o"></i>Data Operasional</a>
                                </li>
<li>
                                    <a href="add_operasional"><i class="fa fa-circle-o"></i>Tambah Transaksi</a>
                                                  </li>

                            </ul>
                        </li>


<?php }else{}
              if($chmenu8 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

    <li class="treeview">
          <a href="#"> <i class="glyphicon glyphicon-inbox"></i> <span>Stok</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
            <ul class="treeview-menu">
                <li>
                    <a href="stok_barang"><i class="fa fa-circle-o"></i>Data Stok</a>
                  </li>
                  <li>
                      <a href="stok_sesuai"><i class="fa fa-circle-o"></i>Penyesuaian Stok</a>
                    </li>
                    <li>
                        <a href="stok_batal"><i class="fa fa-circle-o"></i>Pembatalan Stok</a>
                      </li>
                      <li>
                        <a href="trx_jual"><i class="fa fa-circle-o"></i>Hapus Penjualan</a>
                      </li>

                </ul>
              </li>


<?php }else{}
  if($chmenu9 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                          <li class="treeview">
                              <a href="#"> <i class="glyphicon glyphicon-stats"></i> <span>Laporan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                 <ul class="treeview-menu">
                                  <li>
                                      <a href="report_trxbeli"><i class="fa fa-circle-o"></i>Pembelian</a>
                                  </li>
                                  <li>
                                      <a href="report_trxjual"><i class="fa fa-circle-o"></i>Penjualan</a>
                                  </li>
                                  <li>
                                      <a href="report_operasi"><i class="fa fa-circle-o"></i>Operasional</a>
                                  </li>
                                  <li>
                                      <a href="report_revenue"><i class="fa fa-circle-o"></i>Pendapatan</a>
                                  </li>
                                  <li>
                                      <a href="report_income"><i class="fa fa-circle-o"></i>Laba</a>
                                  </li>

                              </ul>
                          </li>
<?php }else{}
if($chmenu4 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-folder-close"></i> <span>Supplier</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="supplier"><i class="fa fa-circle-o"></i>Data Supplier</a>
                                </li>
<li>
                                    <a href="add_supplier"><i class="fa fa-circle-o"></i>Tambah Supplier</a>
                                                  </li>
                            </ul>
                        </li>
<?php }else{}

if($chmenu3 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-tag"></i> <span>Kategori dan Brand</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="kategori"><i class="fa fa-circle-o"></i>Data Kategori</a>
                                </li>
                                  <li>
                                    <a href="add_kategori"><i class="fa fa-circle-o"></i>Tambah Kategori</a>
                                 </li>

                                 <li>
                                    <a href="merek"><i class="fa fa-circle-o"></i>Data Brand</a>
                                 </li>

                                 <li>
                                    <a href="add_merek"><i class="fa fa-circle-o"></i>Tambah Brand</a>
                                 </li>
                            </ul>
                        </li>


  <?php }else{}

  

if($chmenu10 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>


              <li class="treeview">
                            <a href=""> <i class="glyphicon glyphicon-cog"></i> <span>Pengaturan</span> <span class="pull-right-container"> </span> </a>
                               <ul class="treeview-menu">
                                <li>
                                    <a href="set_general"><i class="fa fa-circle-o"></i>General Setting</a>
                                </li>
                <li>
                <a href="set_themes"><i class="fa fa-circle-o"></i>Theme Setting</a>
                               </li>
                                <li>
                                <a href="admin"><i class="fa fa-circle-o"></i>User Setting</a>
                                                                   </li>
                                                                   <li>
                                <a href="add_jabatan"><i class="fa fa-circle-o"></i>Jabatan</a>
                                                                   </li>
                <li>
                <a href="set_chmod"><i class="fa fa-circle-o"></i>Hak Akses</a>
                                                  </li>
                                                  <li>
                <a href="license"><i class="fa fa-circle-o"></i>LISENSI</a>
                                                  </li>
                            </ul>
                        </li>
<?php }else{} 
if($chmenu11 >= 1 || $_SESSION['jabatan'] == 'admin'){ ?>

                        <li class="treeview">
                            <a href="#"> <i class="glyphicon glyphicon-flag"></i> <span>Satuan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
               <ul class="treeview-menu">
                                <li>
                                    <a href="satuan"><i class="fa fa-circle-o"></i>Data Satuan</a>
                                </li>
                                  <li>
                                    <a href="add_satuan"><i class="fa fa-circle-o"></i>Tambah Satuan</a>
                                 </li>

                            </ul>
                        </li>


  <?php }else{} ?>


                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
