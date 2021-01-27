<?php
date_default_timezone_set('Asia/Jakarta');
include "configuration/config_etc.php";
include "configuration/config_include.php";
require "base_path.php";

$today = date('Y-m-d');
$file = fopen('jabatan.csv', 'w');

$query = "SELECT * FROM jabatan";

fputcsv($file, ["kode", "nama", "no"]);

if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'jabatan.csv';

$newFilePath = $pathMoved.'\jabatan.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);