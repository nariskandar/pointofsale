<?php
$connServer = mysqli_connect('multisolusi.com', 'basic', 'indonesia123', 'basic');

require_once __DIR__ . '/box/spout/src/Spout/Autoloader/autoload.php';

// include "../configuration/config_etc.php";
include "../configuration/config_include.php";
require "../base_path.php";

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;

$ignored = array(".", "..", "uploaded");
$directory_monitor = scandir($pathUploaded);
$arr = [];

foreach($directory_monitor as $get){
    if(!in_array($get, $ignored)){
        $cek = explode(".", $get);
        if($cek[1] == "csv"){
            array_push($arr, $get);
        }else{
            
        }
    }
}


foreach ($arr as $key => $value) {
    $explode = explode(".", $value);
    // var_dump($explode[0]);die;
    if ($explode[0] == "barang") {
        $reader = ReaderFactory::create(Type::CSV);
        $reader->open($pathUploaded.$value);
        
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rn => $get) {
                $result = mysqli_query($connServer, "SELECT * FROM barang WHERE kode='$get[0]'");

                if (mysqli_num_rows($result) > 0) {
                    $sql1 = "UPDATE barang SET barcode='$get[16]', kode='$get[0]', nama='$get[1]', hargabeli='$get[2]', hargajual='$get[3]', keterangan= '$get[4]', kategori='$get[5]', terjual='$get[6]', terbeli='$get[7]', sisa='$get[8]', isipersatuan='$get[9]', terjualeceran='$get[10]', terbelieceran='$get[11]', stokeceran='$get[12]', deposit='$get[14]', brand='$get[15]', satuan='$get[17]', last_update='$get[18]' where kode='$get[0]'";
                } else {
                    $sql1 = "INSERT INTO barang (kode, nama, hargabeli, hargajual, keterangan, kategori, terjual, terbeli, sisa, isipersatuan, terjualeceran, terbelieceran, stokeceran, deposit, brand, barcode, satuan, last_update) values ('$get[0]', '$get[1]', '$get[2]', '$get[3]', '$get[4]', '$get[5]', '$get[6]',  '$get[7]',  '$get[8]',  '$get[9]', '$get[10]', '$get[11]', '$get[12]', '$get[14]', '$get[15]', '$get[16]', '$get[17]', '$get[18]')";
                }
                
                $getData = mysqli_query($connServer, $sql1);
                var_dump($getData);

            }
        }

        

        
    } else if ($explode[0] == "bayar") {
            $reader = ReaderFactory::create(Type::CSV);
            $reader->open($pathUploaded.$value);
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $rn => $get) {
                    $result = mysqli_query($connServer, "SELECT * FROM bayar WHERE nota='$get[0]'");

                    $format = 'Y-m-d';
                    $tgl = str_replace("/", "-", $get[1]);
                    $date = date_format(date_create($tgl), "Y-m-d");

                    if (mysqli_num_rows($result) > 0) {
                        $sql1 = "UPDATE bayar SET tglbayar='$date', bayar='$get[2]', total='$get[3]', kembali='$get[4]', keluar='$get[5]', kasir='$get[6]', last_update='$get[8]' WHERE nota='$get[0]'";
                    }else{
                        $sql1 = "INSERT INTO bayar (nota, tglbayar, bayar, total, kembali, keluar, kasir, last_update) values ('$get[0]', '$date', '$get[2]', '$get[3]', '$get[4]', '$get[5]', '$get[6]', '$get[8]')";
                    }
                    $getData = mysqli_query($connServer, $sql1);
                    var_dump($getData);
                }
            }

        } else if ($explode[0] == "beli") {
            $reader = ReaderFactory::create(Type::CSV);
            $reader->open($pathUploaded.$value);
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $rn => $get) {
                    $result = mysqli_query($connServer, "SELECT * FROM beli WHERE nota='$get[0]'");

                    if (mysqli_num_rows($result) > 0) {
                        $sql1 = "UPDATE beli SET tglbeli='$date', total='$get[2]', supplier='$get[3]', kasir='$get[4]', keterangan='$get[5]', last_update='$get[7]' WHERE nota='$get[0]'";
                    }else {
                        $sql1 = "INSERT INTO beli (nota, tglbeli, total, supplier, kasir, keterangan, last_update) values ('$get[0]', '$date', '$get[2]', '$get[3]', '$get[4]', '$get[5]', '$get[7]')";
                    }
                    $getData = mysqli_query($connServer, $sql1);
                    var_dump($getData);
                }
            }
            
        } else if ($explode[0] == "transaksibeli") {
            $reader = ReaderFactory::create(Type::CSV);
            $reader->open($pathUploaded.$value);
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $rn => $get) {
                    // echo "<pre>".json_encode($get, JSON_PRETTY_PRINT)."</pre>"; continue;
                    $result = mysqli_query($connServer, "SELECT * FROM transaksibeli WHERE no='$get[6]'");
                    if (mysqli_num_rows($result) > 0) {
                        $sql1 = "UPDATE transaksibeli SET nota='$get[0]', kode='$get[1]', nama='$get[2]', harga='$get[3]', jumlah='$get[4]', hargaakhir='$get[5]', flagging='$get[7]', last_update='$get[8]' WHERE no='$get[6]' ";
                    } else {
                        $sql1 = "INSERT INTO transaksibeli (nota, kode, nama, harga, jumlah, hargaakhir, flagging, last_update) values ('$get[0]', '$get[1]', '$get[2]', '$get[3]', '$get[4]', '$get[5]', '$get[7]', '$get[8]')";
                    }
                    
                    $getData = mysqli_query($connServer, $sql1);
                    var_dump($getData);
                }
            }

        } else if ($explode[0] == "transaksimasuk") {
            $reader = ReaderFactory::create(Type::CSV);
            $reader->open($pathUploaded.$value);

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $rn => $get) {
                    $result = mysqli_query($connServer, "SELECT * FROM transaksimasuk WHERE nota='$get[6]'");

                    if (mysqli_num_rows($result) > 0) {
                        $sql1 = "UPDATE transaksimasuk SET kode='$get[1]', nama='$get[2]', harga='$get[3]', hargabeli='$get[4]', jumlah='$get[5]',  hargaakhir='$get[6]', hargabeliakhir='$get[7]', flagging='$get[9]', last_update='$get[10]' WHERE no='$get[6]'";
                    } else {
                        $sql1 = "INSERT INTO transaksimasuk (nota, kode, nama, harga, hargabeli, jumlah, hargaakhir, hargabeliakhir, flagging, last_update) values ('$get[0]', '$get[1]', '$get[2]', '$get[3]', '$get[4]', '$get[5]', '$get[6]', '$get[7]', '$get[9]', '$get[10]')";
                    }
                    $getData = mysqli_query($connServer, $sql1);
                    var_dump($getData);
                }
            }

        }

    }