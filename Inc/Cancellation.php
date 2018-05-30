<?php 

include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';
session_start();
$link=connect();
echo is_login($link);
if(!is_login($link)){
	//header("Location:../Home/Login.php");
}
unset($_SESSION['name']);
unset($_SESSION['psw']);
setcookie(session_name(),'',time()-2600);

 header("Location:../Home/Login.php");
?>