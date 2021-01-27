<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
$barcode = $_GET['barcode'];

$sql = "SELECT barang.*, satuan.nama as nama_satuan FROM barang LEFT JOIN satuan ON barang.satuan = satuan.kode WHERE barang.barcode='".$barcode."' GROUP BY barang.barcode";
$result = mysqli_query($conn, $sql);
echo json_encode(mysqli_fetch_assoc($result));

?>