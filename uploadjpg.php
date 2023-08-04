<?php
date_default_timezone_set("Asia/Seoul");
$time = date("YmdHis",time());
list($microtime,$timestamp) = explode(' ',microtime());
$hash = hash("sha256", $time . "-" . $microtime);

$uploads_dir = './data'; //Directory to save the file that comes from client application.
if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES["file"]["tmp_name"];
    $name = $_FILES["file"]["name"];
    move_uploaded_file($tmp_name, "$uploads_dir/$hash.jpg");

    echo $hash;
}
?>