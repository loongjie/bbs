<?php
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';

$loginname=$_POST['loginname'];
$loginpsw=$_POST['loginpsw'];

$link=connect();
$query="select paw from user where name='{$loginname}'";
$res=execute($link, $query);
$row=mysqli_fetch_assoc($res);

if($row['paw']==$loginpsw){
	echo json_encode(array('status'=>2,'msg'=>'*ok'));	
}else{
	echo json_encode(array('status'=>1,'msg'=>'*密码错误'));
}

?>