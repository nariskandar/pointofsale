<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
include "../../configuration/config_etc.php";
include "../../configuration/config_include.php";
include "../../configuration/config_chmod.php";


        if(!empty($_POST["barang"])) {
            $query ="SELECT
            * 
        FROM
            barang 
        WHERE
            sisa > 0 
            AND barang.nama LIKE '%" .$_POST["barang"]. "%'
        ORDER BY
            barang.nama
            LIMIT 0,10";
            $result = mysqli_query($conn, $query);
        if(!empty($result)) {

?>


    <ul id="barang-list">
<?php
    foreach($result as $s) {
?>
        <li onClick="pilihBarang('<?= $s["barcode"]; ?>');"><?php echo $s["nama"]; ?></li>
<?php } ?>
    </ul>
<?php } } ?>

</script>
