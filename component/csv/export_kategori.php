<?php
require "base_path.php";
date_default_timezone_set('Asia/Jakarta');

$today = date('Y-m-d');
$file = fopen('kategori.csv', 'w');

$query = "SELECT * FROM kategori";


if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'kategori.csv';

$newFilePath = $pathMoved.'\kategori.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);