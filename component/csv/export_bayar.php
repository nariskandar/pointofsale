<?php
require "base_path.php";
date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');
$file = fopen('bayar.csv', 'w');

$query = "SELECT * FROM bayar WHERE DATE(last_update) = '$today'";


if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'bayar.csv';
 
$newFilePath = $pathMoved.'\bayar.csv';

$fileMoved = rename($currentFilePath, $newFilePath);