<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';


if(isset($_POST['submit'])){
	
	$link=connect();
	include '../Inc/loginCheck.php';
	$_POST=escape($link, $_POST);
	$query="select * from user where name='{$_POST['name']}' and paw='{$_POST['pw']}'";
	$result=execute($link, $query);
	if(mysqli_num_rows($result)==1){
		session_start();
		$_SESSION['name']=$_POST['name'];
		$_SESSION['psw']=$_POST['pw'];	

		echo "<script>alert('恭喜，登陆成功！！')</script>";
		header("Location:Index.php");
	}else{
		echo "<script>alert('登陆失败，请重新登陆')</script>";
		header("Location:Login.php");
	}
}

?>

<?php include '../Inc/header.php';?>

   <div style="margin-top:55px;"></div>

   <div id="register" class="auto">
		<h2>欢迎登陆olaf体育论坛</h2>
		<form method="post" class="loginform">
			<label>用户名：<input type="text" name="name" class="loginname" /><span></span></label>
			<label>密码：<input type="password" name="pw" class="loginpsw" /><span></span></label>
			<label>验证码：<input name="vcode" name="vocode" type="text" class="loginvcode" /><span></span></label>
			<img  class="vcode" title="点击刷新" src="../Inc/test.php" align="absbottom" onclick="this.src='../Inc/test.php?'+Math.random();"></img>
			<div style="clear:both;"></div>
			<input class="btn" name="submit" type="submit" value="登陆" />
		</form>
	</div>

<?php include '../Inc/footer.php';?>