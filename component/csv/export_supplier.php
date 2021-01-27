<?php
require "base_path.php";
date_default_timezone_set('Asia/Jakarta');

$today = date('Y-m-d');

$file = fopen('supplier.csv', 'w');

$query = "SELECT * FROM supplier WHERE DATE(tgldaftar) = '$today'";


if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'supplier.csv';
// var_dump($currentFilePath);
// die;

$newFilePath = $pathMoved.'\supplier.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);