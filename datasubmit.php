<?php
date_default_timezone_set("Asia/Seoul");
$time = date("YmdHis",time());
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
                                    <h6 class="m-0 font-weight-bold text-primary">승인번호 관리</h6>
                                </div>
                                <div class="card-body">
                                    <p>분석을 위해 승인번호를 발급 및 관리합니다</p>
				  <a href="process.php?key=<?php echo $time ?>&type=dpa_winapp&c=gc" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-upload fa-sm text-white-50"></i> 승인번호 발급요청</a>
				  <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-upload fa-sm text-white-50"></i> 기존 승인번호 조회</a>
                                </div>
                            </div>
                        </div>

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-12">
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">분석</h6>
                                </div>
                                <div class="card-body">
				  <form action="analysis.php" method="post">
					  <input type="hidden" name="c" id="a">
					  Code: <input type="text" name="code" id="code"><br/>
					  Data: <input type="text" name="data" id="data"><br/>
					  Area: <input type="text" name="area" id="area"><br/>
					  <input type="submit" value="Submit" name="submit" class="btn btn-sm btn-primary shadow-sm">
				</form>
                                </div>
                            </div>
                        </div>

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-12">
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">RAW데이터 업로드</h6>
                                </div>
                                <div class="card-body">
                                    <p>업로드 데이터를 선택하세요.</p>
				  <form action="upload.php" method="post" enctype="multipart/form-data">
					  <input type="file" name="fileToUpload" id="fileToUpload" class="">
					  <input type="submit" value="Upload Image" name="submit" class="btn btn-sm btn-primary shadow-sm">
				</form>
                                </div>
                            </div>
                        </div>

<?php
include_once 'tail.php';
?>