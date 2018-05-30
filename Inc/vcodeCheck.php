<?php

session_start();
$vcode=$_POST['vcode'];
if(strtolower($vcode)==strtolower($_SESSION['authnum_session'])){
	echo json_encode(array('status'=>1,'msg'=>'*验证ok'));
}else{
	echo json_encode(array('status'=>2,'msg'=>'*验证失败'));
}

?>











