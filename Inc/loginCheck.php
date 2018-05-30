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




?>