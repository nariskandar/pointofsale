<?php
require "base_path.php";
date_default_timezone_set('Asia/Jakarta');

$today = date('Y-m-d');

// if ($report_daily){
    // mkdir($pathMoved);

    require __DIR__ . "/component/csv/export_barang.php";
    require __DIR__ . "/component/csv/export_bayar.php";
    require __DIR__ . "/component/csv/export_beli.php";
    require __DIR__ . "/component/csv/export_kategori.php";
    require __DIR__ . "/component/csv/export_supplier.php";
    require __DIR__ . "/component/csv/export_transaksibeli.php";
    require __DIR__ . "/component/csv/export_transaksimasuk.php";

    header('Location: index');


    // require __DIR__ . "/component/csv/export_brand.php";
    // require __DIR__ . "/component/csv/export_chmenu.php";
    // require __DIR__ . "/component/csv/export_data.php";
    // require __DIR__ . "/component/csv/export_info.php";
    // require __DIR__ . "/component/csv/export_sql.php";
    // require __DIR__ . "/component/csv/export_operasional.php";
    // require __DIR__ . "/component/csv/export_satuan.php";
    // require __DIR__ . "/component/csv/export_jabatan.php";