<?php
date_default_timezone_set('Asia/Jakarta');
include "configuration/config_etc.php";
include "configuration/config_include.php";
require "base_path.php";

$today = date('Y-m-d');
$file = fopen('barang.csv', 'w');

$query = "SELECT * FROM barang WHERE DATE(last_update) = '$today'";


if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'barang.csv';

$newFilePath = $pathMoved.'\barang.csv';

$fileMoved = rename($currentFilePath, $newFilePath);