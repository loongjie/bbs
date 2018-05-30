<?php
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';


$link1=connect();
$username=$_POST['username'];
$query="select * from user where name='{$username}'";
$ret=execute($link1, $query);
if(mysqli_affected_rows($link1)==1){
	echo json_encode(array('status'=>1,'msg'=>"该用户名已注册，请重新注册"));
}else{
	echo json_encode(array('status'=>2,'msg'=>"*ok"));
}









?>