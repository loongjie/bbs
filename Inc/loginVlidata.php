<?php
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';

$loginname=$_POST['loginname'];

$link=connect();
$query="select * from user where name='{$loginname}' ";
$res=execute($link,$query);
if(mysqli_affected_rows($link)==1){
	echo json_encode(array('status'=>1,'msg'=>'*ok'));
}else{
	echo json_encode(array('status'=>2,'msg'=>'*用户名不存在'));
}








?>