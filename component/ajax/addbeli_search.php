<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "../../configuration/config_etc.php";
include "../../configuration/config_include.php";
include "../../configuration/config_chmod.php";

$search = $_POST['barang'];
// $sql = mysqli_query($conn, "select * from barang");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['barang'])) {
        $query = "SELECT barang.*, satuan.nama as nama_satuan FROM barang
        LEFT JOIN satuan ON barang.satuan = satuan.kode
        WHERE barang.barcode LIKE '%$search%'";
        $hasil = mysqli_query($conn, $query);
        if (empty($hasil)) {
            echo $search;
        } else {
            while ($row = mysqli_fetch_assoc($hasil)) {
                $rows[] = $row;
                    echo json_encode($rows);
            }
        }
    } 
}