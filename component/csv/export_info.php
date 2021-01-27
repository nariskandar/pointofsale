<?php
date_default_timezone_set('Asia/Jakarta');
include "configuration/config_etc.php";
include "configuration/config_include.php";
require "base_path.php";

$today = date('Y-m-d');
$file = fopen('info.csv', 'w');

$query = "SELECT * FROM info";

fputcsv($file, ["nama", "avatar", "tanggal", "isi", "id"]);

if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'info.csv';

$newFilePath = $pathMoved.'\info.csv';

$fileMoved = rename($currentFilePath, $newFilePath);