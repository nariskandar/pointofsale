<?php
date_default_timezone_set('Asia/Jakarta');
include "configuration/config_etc.php";
include "configuration/config_include.php";
require "base_path.php";

$today = date('Y-m-d');
$file = fopen('data.csv', 'w');

$query = "SELECT * FROM data";

fputcsv($file, ["nama", "tagline", "alamat", "notelp", "signature", "avatar", "no"]);

if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'data.csv';

$newFilePath = $pathMoved.'\data.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);