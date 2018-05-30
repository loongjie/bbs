<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';

?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
<title>注册用户名</title>
<meta charset="utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="Style/rehister.css">
<script type="text/javascript" src="Style/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="Style/register.js"></script>
<script type="text/javascript" src="Style/login.js"></script>
</head>
<body>
<!--头部-->
<div class="top">
<div class="top_header">olaf体育论坛</div>
<p><a href="../Home/Index.php">首&nbsp;&nbsp;页</a></p>
<div class="top-right">
<?php 
   $link=connect();  
   //if($flag=is_login($link)){
   if(isset($_SESSION['name'])){
$html=<<<A
          <span style="color:white;">你好，{$_SESSION['name']}<span> <span style="color:white;">||</span>
		 <a href="../Inc/Cancellation.php">注销</a>
A;
   echo $html;
   }else{
$html=<<<A
     <a href="../Home/Register.php">注&nbsp;册</a> &nbsp;||
     <a href="../Home/Login.php">登&nbsp;陆</a>
A;
    echo $html;
   }

?>
</div>
</div>



