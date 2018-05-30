<?php 

include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';

//$_GET['id'] 帖子的id
$link=connect();

//if(!$user_id=is_login($link)){
//	echo "<script>alert('请先登录！！')</script>";
//}

if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
	echo "<script>alert('提交的参数不合法！')</script>";
}

$queuser="select * from bbs_content where id={$_GET['id']}";
$res=execute($link, $queuser);

if(mysqli_num_rows($res)==1){
	$rowdlt=mysqli_fetch_assoc($res);
	
	
		$q="delete from bbs_content where id={$_GET['id']}";
		$da=execute($link, $q);
		
		if(mysqli_affected_rows($link)==1){
			echo "<script>alert('删除成功！')</script>";
			header( "Location:".$_SERVER[ 'HTTP_REFERER ']); 
		}else{
			echo "<script>alert('删除失败！')</script>";
		}
	
}else{
	echo "<script>alert('提交的参数不合法！')</script>";
}



?>