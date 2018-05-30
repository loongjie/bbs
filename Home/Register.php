<?php
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';

if(isset($_POST['submit'])){
	$link=connect();
	include_once '../Inc/registerCheck.inc.php';
	$query="insert into user(name,paw,register_time) values('{$_POST['name']}','{$_POST['pw']}',now())";
	execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		echo "<script>alert('注册成功！！！')</script>";
		header("Location:Login.php");
	}else{
		echo "<script>alert('注册失败！！！')</script>".mysqli_error($link);
		header("Location:Register.php");
	}
	
}
?>

<?php include '../Inc/header.php';?>

   <div style="margin-top:55px;"></div>

   <div id="register" class="auto">
		<h2>欢迎注册成为 olaf体育社区会员</h2>
		<form method="post" id="form">
			<label>用户名：<input type="text" name="name" id="username" blur="checkname()" /><span>*用户名不得为空，并且长度不得超过32个字符</span></label>
			<label>密码：<input type="password" name="pw" id="psw" /><span>*密码不得少于6位</span></label>
			<label>确认密码：<input type="password" name="confirm_pw" id="mpsw"  /><span>*请输入与上面一致</span></label>
			<label>验证码：<input name="vcode" name="vocode" type="text" id="vcode" /><span>*请输入下方验证码</span></label>
			<img  class="vcode" title="点击刷新" src="../Inc/test.php" align="absbottom" onclick="this.src='../Inc/test.php?'+Math.random();"></img>
			<div style="clear:both;"></div>
			<input class="btn" name="submit" type="submit" value="确定注册" />
		</form>
	</div>

<?php include '../Inc/footer.php';?>




































