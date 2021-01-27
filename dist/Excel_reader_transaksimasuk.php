<?php
require_once __DIR__ . '/box/spout/src/Spout/Autoloader/autoload.php';

include "../configuration/config_etc.php";
include "../configuration/config_include.php";

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;

$reader = ReaderFactory::create(Type::CSV);

$reader->open('D:\pos\21\tb_transaksimasuk_2020-12-21.csv');
$getData = mysqli_query($conn, "SELECT * FROM transaksimasuk");

foreach ($reader->getSheetIterator() as $sheet) {
    foreach ($sheet->getRowIterator() as $rn => $get) {
        
$result = mysqli_query($conn, "SELECT * FROM transaksimasuk");

        if (mysqli_num_rows($result) > 0) {
        $sql1 = "INSERT INTO transaksimasuk (nota, kode, nama, harga, hargabeli, jumlah, hargaakhir, hargabeliakhir, flagging) values ('$get[0]', '$get[1]', '$get[2]', '$get[3]', '$get[4]', '$get[5]', '$get[6]',  '$get[7]', '$get[9]')";

        }

        $getData = mysqli_query($conn, $sql1);
    }
}
