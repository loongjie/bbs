<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';
session_start();
$link=connect();
if(!$user_id=is_login($link)){
	echo "<script>alert('请先登录，才能评论')</script>";
}
$queryshow="select * from bbs_content where id={$_GET['id']}";
$reshow=execute($link, $queryshow);
$rowshow=mysqli_fetch_assoc($reshow);
if(!isset($_GET['id'])||! is_numeric($_GET['id'])||mysqli_num_rows($reshow)!=1){
	echo "<script>alert('参数提交错误，将返回首页')</script>";
	header("Refresh:1;url='index.php'");
}


if(isset($_POST['rep_submit'])){
	if(empty($_POST['content'])){
		echo "<script>alert('回复不能为空！！！')</script>";
	}
	$query="insert into bbs_reply (content_id,reply_content,reply_time,user_id) values ({$_GET['id']},'{$_POST['content']}',now(),{$user_id})";
	$res=execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		echo "<script>alert('回复成功！！')</script>";
		sleep(3);
		header("location:show.php?id={$_GET['id']}");
	}else{
		echo "<script>alert('额，出现问题了！！')</script>";
		sleep(1);
		header("location:reply.php?id={$_GET['id']}");
	}
	
}
?>

<?php include '../Inc/header.php';?>
<link rel="stylesheet" type="text/css" href="Style/reply.css">

	<div class="reply_top">
	   <a href="Index.php">首&nbsp;&nbsp;&nbsp;页</a>&gt;回复帖子
	</div>
	
	<div class="reply_content">
	   <p>回复：<?php echo "{$rowshow['title']}" ?></p>
	   <form method="post">
	      <textarea name="content" class="content"></textarea>
	      <input type="submit" name="rep_submit" class="rep_submit" value="回复">
	      <div style="clear: both;"></div> 
	   </form>
	</div>


<?php include '../Inc/footer.php';?>













