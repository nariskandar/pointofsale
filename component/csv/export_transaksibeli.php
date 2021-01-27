<?php
require "base_path.php";
date_default_timezone_set('Asia/Jakarta');


$today = date('Y-m-d');
$file = fopen('transaksibeli.csv', 'w');

$query = "SELECT * FROM transaksibeli WHERE DATE(last_update) = '$today'";



if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'transaksibeli.csv';

$newFilePath = $pathMoved.'\transaksibeli.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);