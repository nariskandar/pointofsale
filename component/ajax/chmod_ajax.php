<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "../../configuration/config_etc.php";
include "../../configuration/config_include.php";
include "../../configuration/config_chmod.php";

$search = $_POST['userjabatan'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['userjabatan'])) {
        $query = "SELECT * FROM chmenu WHERE userjabatan = '$search'";
        $hasil = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($hasil)) {
            $rows[] = $row;
                echo json_encode($rows);
        }
    }
}
