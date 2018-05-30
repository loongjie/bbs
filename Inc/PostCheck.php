<?php 

if(empty($_POST['checkban'])){
	echo "<script>alert('请选择板块')</script>";
	die();
}
if(empty($_POST['title'])){
	echo "<script>alert('标题不能为空')</script>";
	die();
}
if(empty($_POST['content'])){
	echo "<script>alert('内容不能为空')</script>";
	die();
}
if(mb_strlen($_POST['title'])>265){
	echo "<script>alert('标题太长了，精简点吧')</script>";
	die();
}

?>