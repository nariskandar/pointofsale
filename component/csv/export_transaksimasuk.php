<?php
require "base_path.php";
date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');
$file = fopen('transaksimasuk.csv', 'w');
 

$query = "SELECT * FROM transaksimasuk WHERE DATE(last_update) = '$today'";


if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'transaksimasuk.csv';

$newFilePath = $pathMoved.'\transaksimasuk.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);