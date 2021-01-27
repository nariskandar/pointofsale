<?php
date_default_timezone_set('Asia/Jakarta');
include "configuration/config_etc.php";
include "configuration/config_include.php";
require "base_path.php";

$today = date('Y-m-d');
$file = fopen('operasional.csv', 'w');


$query = "SELECT * FROM operasional WHERE DATE(tanggal) = '$today'";

fputcsv($file, ["kode", "nama", "tanggal", "biaya", "keterangan", "kasir", "no"]);


if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'operasional.csv';

$newFilePath = $pathMoved.'\operasional.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);