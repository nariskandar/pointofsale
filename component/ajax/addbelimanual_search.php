<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "../../configuration/config_etc.php";
include "../../configuration/config_include.php";
include "../../configuration/config_chmod.php";


    if(!empty($_POST["barang"])) {
        $query ="SELECT barang.*, satuan.nama as nama_satuan FROM barang LEFT JOIN satuan ON barang.satuan = satuan.kode WHERE sisa > 0 AND barang.nama LIKE '" . $_POST["barang"] . "%' OR barang.kode LIKE '" . $_POST["barang"] . "%' ORDER BY barang.NO LIMIT 0,6";
        $result = mysqli_query($conn, $query);
    if(!empty($result)) {

?>


    <ul id="barang-list">
<?php
    foreach($result as $s) {
        // var_dump($s);
?>
        <li onClick="pilihBarang('<?= $s["barcode"]; ?>');"><?php echo $s["nama"]; ?></li>
<?php } ?>
    </ul>
<?php } } ?>

</script>
