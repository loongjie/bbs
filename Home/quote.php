<?php 
include_once '../Inc/configi.inc.php';
include_once '../Inc/mysql.inc.php';
include_once '../Inc/tools.inc.php';
session_start();
$link=connect();
if(!$user_id=is_login($link)){
	echo "<script>alert('请先登录，才能评论')</script>";
}


$que="select user.name,bbs_content.title,bbs_reply.reply_content from user,bbs_content,bbs_reply
	  where user.id=bbs_content.user_id and bbs_content.id=bbs_reply.content_id
	  and bbs_content.id={$_GET['content_id']} and bbs_reply.id={$_GET['reply_id']}";
$rue=execute($link, $que);
$row=mysqli_fetch_assoc($rue);

if(isset($_POST['rep_submit'])){
	//var_dump($_POST);exit();
	if(empty($_POST['content'])){
		echo "<script>alert('提交的内容不能为空')</script>";
	}
	$query="insert into bbs_reply(content_id,quote_id,reply_content,reply_time,user_id)
			values({$_GET['content_id']},{$_GET['reply_id']},'{$_POST['content']}',now(),{$user_id})";
	$res=execute($link, $query);
	if(mysqli_affected_rows($link)==1){
		echo "<script>alert('回复成功')</script>";
		sleep(1);
		header("Location:show.php?id={$_GET['content_id']}");
	}else{
		echo "<script>alert('回复失败？？？')</script>";
	}
}

?>

<?php include '../Inc/header.php';?>

<link rel="stylesheet" type="text/css" href="Style/reply.css">

	<div class="reply_top">
	   <a href="Index.php">首&nbsp;&nbsp;&nbsp;页</a>&gt;回复帖子
	</div>
	
	
	
	<div class="reply_content">
	   <p><?php echo "{$row['name']}"?>：<?php echo "{$row['title']}"?></p>
	   <div class="huifu">
	       <p>对于该评论，发表你的态度：</p>
	         <p>    <?php echo "{$row['reply_content']}"?></p>
	  </div>
	   <form method="post">
	      <textarea name="content" class="content"></textarea>
	      <input type="submit" name="rep_submit" class="rep_submit" value="回复">
	      <div style="clear: both;"></div> 
	   </form>
	</div>

<?php include '../Inc/footer.php';?>
