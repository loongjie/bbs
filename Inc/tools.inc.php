<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';

//判断用户是否登陆，用户信息已经保存在SESSION中,返回的是user_id

function is_login($link){

	if(isset($_SESSION['name'])&&isset($_SESSION['psw'])){
		$name=$_SESSION['name'];
		$psw=$_SESSION['psw'];
		$query="select * from user where name='{$name}' and paw='{$psw}'";
		//var_dump($query);
		$result=execute($link, $query);
		if($data=mysqli_num_rows($result)==1){
			$data=mysqli_fetch_assoc($result);
			return $data['id'];
		}else{
			return false;
		}
	}else{
		return false;
	}
	
}


?>