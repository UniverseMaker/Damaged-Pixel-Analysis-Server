<?php
include_once '../config/dbconfig.php';

date_default_timezone_set("Asia/Seoul");
$time = date("YmdHis",time());

if(!isset($_REQUEST['data']) || strpos($_REQUEST['data'], "/") === false){
	echo "<center><h1>??? ???? ???????1</h1></center>";
	exit();
}

if(!isset($_REQUEST['code'])){
	echo "<center><h1>??? ???? ???????2</h1></center>";
	exit();
}

$query = "SELECT * FROM `app_3rdparty_kv` WHERE code='{$_REQUEST['code']}' and name='border' ORDER BY id DESC";
$result = mysqli_query($dbconnect, $query);
$data = mysqli_fetch_assoc($result);
//echo $query;

if(!isset($data['value'])){
	echo "<center><h1>??? ???? ???????3</h1></center>";
	exit();
}

$b = explode("/", $data['value']);
$rs = explode("/", $_REQUEST['data']);
//$w1 = imagesx("data/".$rs[0].".jpg");
//$h1 = imagesy("data/".$rs[0].".jpg");
//$w2 = imagesx("data/".$rs[1].".jpg");
//$h2 = imagesy("data/".$rs[1].".jpg");
list( $w1, $h1 ) = getimagesize( "data/".$rs[0].".jpg" );
list( $w2, $h2 ) = getimagesize( "data/".$rs[1].".jpg" );

if(!file_exists("data/".$rs[1]."_out.jpg")){

$ec = 0;
// Open input and output image
$rs1 = imagecreatefromJPEG("data/".$rs[0].".jpg") or die('Problem with source');
$rs2 = imagecreatefromJPEG("data/".$rs[1].".jpg") or die('Problem with source');
$ro1 = ImageCreateTrueColor(imagesx($rs1),imagesy($rs1)) or die('Problem In Creating image');
$ro2 = ImageCreateTrueColor(imagesx($rs2),imagesy($rs2)) or die('Problem In Creating image');

$tc = 0;
$fc = 0;
// scan image pixels
for ($x = 0; $x < imagesx($rs2); $x++) {
    for ($y = 0; $y < imagesy($rs2); $y++) {
	$tc++;
	$src_pix1 = imagecolorat($rs1,$x,$y);
	$src_pix_array1 = rgb_to_array($src_pix1);
        	$src_pix2 = imagecolorat($rs2,$x,$y);
        	$src_pix_array2 = rgb_to_array($src_pix2);
	if($x > $b[0] && $x < ($b[0] + $b[2]) && $y > $b[1] && $y < ($b[1] + $b[3])){
            	// check for chromakey color
           	if ($src_pix_array2[0] > 200 && $src_pix_array2[1] > 50 ) { //&& $src_pix_array2[2] == 255
			$fc++;
                		$src_pix_array2[0] = 254;
                		$src_pix_array2[1] = 254;
                		$src_pix_array2[2] = 254;

			imagesetpixel($ro1, $x, $y, imagecolorallocate($ro1, $src_pix_array2[0], $src_pix_array2[1], $src_pix_array2[2]));
			imagesetpixel($ro2, $x, $y, imagecolorallocate($ro2, $src_pix_array2[0], $src_pix_array2[1], $src_pix_array2[2]));
            	}
		else{
			imagesetpixel($ro1, $x, $y, imagecolorallocate($ro1, $src_pix_array1[0], $src_pix_array1[1], $src_pix_array1[2]));
			imagesetpixel($ro2, $x, $y, imagecolorallocate($ro2, $src_pix_array2[0], $src_pix_array2[1], $src_pix_array2[2]));
		}
	}
	else{
		imagesetpixel($ro1, $x, $y, imagecolorallocate($ro1, $src_pix_array1[0], $src_pix_array1[1], $src_pix_array1[2]));
		imagesetpixel($ro2, $x, $y, imagecolorallocate($ro2, $src_pix_array2[0], $src_pix_array2[1], $src_pix_array2[2]));
	}
    }
}


// write $out to disc

imagejpeg($ro1, "data/" . $rs[0] . "_out.jpg",80) or die('Problem saving output image');
imagedestroy($ro1);
imagejpeg($ro2, "data/" . $rs[1] . "_out.jpg",80) or die('Problem saving output image');
imagedestroy($ro2);

$query = "INSERT INTO `app_3rdparty_kv` (type, code, name, value, time, status) VALUES ('dpa_analysis', '{$_REQUEST['code']}', 'result', '{$tc}/{$fc}', '{$time}', 'request')";
$result = mysqli_query($dbconnect, $query);

}
else{
	$ec = 1;
}

$query = "SELECT * FROM `app_3rdparty_kv` WHERE code='{$_REQUEST['code']}' and name='result' ORDER BY id DESC";
$result = mysqli_query($dbconnect, $query);
$data = mysqli_fetch_assoc($result);
$rr = explode("/", $data['value']);
$ft = ((float)$rr[1] / (float)$rr[0]);
$ft2 = ((float)$rr[1] / (float)$rr[0]) * 100;
$fts = number_format($ft2, 2, '.', '');
$ac = (float)$_REQUEST['area'] * $ft;
$acs = number_format($ac, 2, '.', '');

// split rgb to components
function rgb_to_array($rgb) {
    $a[0] = ($rgb >> 16) & 0xFF;
    $a[1] = ($rgb >> 8) & 0xFF;
    $a[2] = $rgb & 0xFF;

    return $a;
}
?>

<?php
include_once 'head.php';
?>

<?php
if(isset($_REQUEST['msg'])){
	echo '
		<!-- Content Column -->
                        <div class="col-lg-12 mb-12">
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Message</h6>
                                </div>
                                <div class="card-body">
                                    <p>'.$_REQUEST["msg"].'</p>
	';

	if(isset($_REQUEST['data'])){
		echo '
				<p>Received Data: '.$_REQUEST["data"].'</p>
		';
	}

	echo '
                                </div>
                            </div>
                        </div>
	';
}
?>

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-12">
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">분석결과 <?php echo $ec ?></h6>
                                </div>
                                <div class="card-body">
				<table class="table" style="width:100%;">
					<tr>
						<td><b>
						TC: <?php echo $rr[0] ?> / 
						FC: <?php echo $rr[1] ?> / 
						F/T: <?php echo $fts ?><br/>
						Area: <?php echo $_REQUEST['area'] ?>m<sup>2</sup> / 
						Area-C: <?php echo $acs ?>m<sup>2</sup>
						</b></td>
						<td></td>
					</tr>
					<tr>
						<td style="width:50%;"><img style="display: block; max-width: 100%; height: auto; margin-left: auto; margin-right: auto;" src="<?php echo "data/".$rs[0]."_out.jpg" ?>"></img></td>
						<td style="width:50%;"><img style="display: block; max-width: 100%; height: auto; margin-left: auto; margin-right: auto;" src="<?php echo "data/".$rs[1]."_out.jpg" ?>"></img></td>
					</tr>
				</table>
                                </div>
                            </div>
                        </div>

<?php
include_once 'tail.php';
?>