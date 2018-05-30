<?php 

if(empty($_POST['name'])){
	echo "<script>alert('用户名不能为空！！')</script>";
	die();
}
if(mb_strlen($_POST['name'])>32){
	echo "<script>alert('用户名长度不能大于32！！')</script>";
	die();
}
if(mb_strlen($_POST['pw'])<6){
	echo "<script>alert('密码不能小于6位！！')</script>";
	die();
}
if($_POST['confirm_pw']!=$_POST['pw']){
	echo "<script>alert('输入的两次密码不一样！！')</script>";
	die();
}

$_POST=escape($link, $_POST);//转义为了顺利入库
$query="select * from user where name={$_POST['name']}";
$ret=execute($link, $query);
if(mysqli_affected_rows($link)==1){
	echo "<script>alert('该用户名已注册，请重新注册')</script>";
	die();
}

?>