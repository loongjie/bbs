<?php
include_once '../Inc/mysql.inc.php';
include_once '../Inc/configi.inc.php';
session_start();


if($_FILES['the_file']['error']>0){
	switch ($_FILES['the_file']['error']) {
		case '1':
			echo "上传文件超出最大值";
			break;
		case '2':
			echo "上传文件超出表单指定最大值";
			break;
		case '3':
			echo "文件部分上传";
			break;
		case '4':
			echo "文件没有上传";
			break;
		case '6':
			echo "php.ini没有指定目录";			
			break;
		case '7':
			echo "写文件失败";
			break;				
		case '8':
			echo "php扩展停止了文件上传进程";
			break;
	}
	exit;
}
if($_FILES['the_file']['type']!='image/png'){
	echo "上传文件格式有误";
	exit;
}

$upload_file='upload/'.$_FILES['the_file']['name'];
if(is_uploaded_file($_FILES['the_file']['tmp_name'])){

	if(!move_uploaded_file($_FILES['the_file']['tmp_name'], iconv('utf-8', 'gb2312', $upload_file))){
		echo "文件没有保存到正确文件夹";
		exit;
	}
}else{
	echo "不是上传文件，请重试";
	exit;
}

$link=connect();
$query="update user set photo='{$_FILES['the_file']['name']}' where name='{$_SESSION['name']}'";
$result=execute($link, $query);
header("Location:index.php");











?>