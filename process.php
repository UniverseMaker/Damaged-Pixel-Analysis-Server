<?php
include_once '../config/dbconfig.php';

//파라메터 수신
if(get_magic_quotes_gpc())
{
	$key = stripslashes($_REQUEST["key"]);
}
else
{
	$key = $_REQUEST["key"];
}

if(isset($_REQUEST["key"]) == false || $key == ""){
	echo "<center><h1>??? ???? ??????</h1></center>";
	exit;
}

date_default_timezone_set("Asia/Seoul");
$time = date("Ymd His",time());

if($_REQUEST["c"] == "gc"){
	if($_REQUEST["type"] == "dpa_winapp"){
		$query = "SELECT * FROM `app_3rdparty_approval` WHERE type='dpa_winapp_{$key}' ORDER BY id DESC";
		$result = mysqli_query($dbconnect, $query);
		$data = mysqli_fetch_assoc($result);

		if(!isset($data['code'])){
			$code = (string)time();
			$query = "INSERT INTO `app_3rdparty_approval` (type, code, status, time) VALUES ('dpa_winapp_{$key}', '{$code}', 'request', '{$time}')";
			$result = mysqli_query($dbconnect, $query);
		
			echo $code;
			header( 'Location: datasubmit.php?msg=Code Generated&data='.$code );
		}
	}
}
else if($_REQUEST["c"] == "cc"){
	$p1 = $_REQUEST['p1'];
	$p2 = $_REQUEST['p2'];
	$p3 = $_REQUEST['p3'];
	
	echo (int)(floatval($p1) / floatval($p2) * floatval($p3));
}
else if($_REQUEST["c"] == "ic"){
	$query = "INSERT INTO `app_3rdparty_kv` (type, code, name, value, time, status) VALUES ('dpa_winapp_{$key}', '{$_REQUEST['code']}', '{$_REQUEST['name']}', '{$_REQUEST['data']}', '{$time}', 'request')";
	$result = mysqli_query($dbconnect, $query);
	
}
else if($_REQUEST["c"] == "upload"){
	$target_dir = "data/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	  if($check !== false) {
	    echo "File is an image - " . $check["mime"] . ".";
	    $uploadOk = 1;
	  } else {
	    echo "File is not an image.";
 	    $uploadOk = 0;
	  }
}
}

?>

