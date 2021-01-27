<?php
date_default_timezone_set('Asia/Jakarta');
include "configuration/config_etc.php";
include "configuration/config_include.php";
require "base_path.php";

$today = date('Y-m-d');
$file = fopen('chmenu.csv', 'w');

$query = "SELECT * FROM chmenu";

fputcsv($file, ["userjabatan", "menu1", "menu2", "menu3", "menu4", "menu5", "menu6", "menu7", "menu8", "menu9", "menu10"]);

if ($rows = mysqli_query($conn, $query)) {
    while ($row = mysqli_fetch_assoc($rows)){
        fputcsv($file, $row);
    }
}

fclose($file);

$currentFilePath = $pathIndex.'chmenu.csv';

$newFilePath = $pathMoved.'\chmenu.csv';
 
$fileMoved = rename($currentFilePath, $newFilePath);