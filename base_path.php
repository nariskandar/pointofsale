<?php
$today = date('Y-m-d');


$pathIndex      = "D:/xampp 5.6/htdocs/pointofsale/";

if(!file_exists(__DIR__ . "/report_daily/receive_data/$today")){
    mkdir(__DIR__ . "/report_daily/receive_data/$today");
}
$pathMoved =  __DIR__ . "/report_daily/receive_data/$today";

if(!file_exists(__DIR__ . "/report_daily/upload_data/$today")){
    mkdir(__DIR__ . "/report_daily/upload_data/$today");
}

$pathUploaded   = __DIR__ . "/report_daily/receive_data/$today/";


$pathUploadData = __DIR__ . "/report_daily/upload_data/$today/";

$pathAfterUploadData = __DIR__ . "/report_daily/after_upload_data";